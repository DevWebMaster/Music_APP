import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux'
import { FlatList, StyleSheet, View, Text, TouchableOpacity } from 'react-native'
import { Container, Content, Header, Icon } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { COLOR, Database, Styles } from '../../constants'
import { ChatInput, ThreadMessage, UserAvatars, Footers } from '../../components'

export default ({ navigation, route }) => {
    const { user } = useSelector(state => state.auth)
    const { name, id: activeMusic, user1 = null, user2 = null, user3 = null } = route.params
    const [messageList, setMessageList] = useState({})
    const [message, setMessage] = useState('')
    const [joined, setJoined] = useState(false)
    let flatList = null
    const sendMessage = () => {
        if (message != '') {
            if (!joined) {
                Database.ref(`users/${activeMusic}`).on('value', async snapshots => {
                    const result = Object.values(snapshots.val() ? snapshots.val() : {})
                    const isJoin = result.find(e => e.userid == user.id)
                    if (!isJoin) {
                        setJoined(true)
                        Database.ref(`users/${activeMusic}`).push({ userid: user.id, email: user.email, avatar: user.profile_avatar ? user.profile_avatar : '' })
                    }
                })
            }
            const data = { message, username: user.username, email: user.email, user: user.id, createdAt: new Date().valueOf(), avatar: user.profile_avatar ? user.profile_avatar : '' }
            Database.ref(`message/${activeMusic}`).push(data).then(e => {
                setMessage('')
            }).catch(error => {
                console.log(error)
            })
        }
    }

    const loadMessage = async () => {
        Database.ref(`message/${activeMusic}`).on('value', async snapshot => {
            setMessageList(snapshot.val())
        })
    }

    useEffect(() => {
        loadMessage()
    }, [navigation])


    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient1}>
                <Header style={[S.header]} androidStatusBarColor={`#2e3570`}>
                    <View style={[{ width: '20%' }]}>
                        <TouchableOpacity onPress={() => navigation.goBack()}>
                            <Icon type="Entypo" name="chevron-small-left" style={[S.CLW, S.F28]} />
                        </TouchableOpacity>
                    </View>
                    <Text style={[S.CLW, S.FW700, S.FRoboto, S.F20, S.Tcenter, { width: '60%' }]} numberOfLines={1}>{name}</Text>
                    <View style={[S.ROW, S.PV10, S.Jend, { width: '20%' }]}>
                        <UserAvatars user={user1} style={[S.avatar2Cover, S.zIndex3]} />
                        <UserAvatars user={user2} style={[S.avatar2Cover, S.zIndex2]} />
                        <UserAvatars user={user3} style={[S.avatar2Cover, S.zIndex1]} />
                    </View>
                </Header>
                {
                    messageList ?
                        <FlatList
                            style={[S.PH20]}
                            ref={ref => flatList = ref}
                            data={Object.values(messageList)}
                            showsVerticalScrollIndicator={false}
                            onContentSizeChange={() => flatList.scrollToEnd()}
                            keyExtractor={(item, index) => `${index}`}
                            renderItem={({ item }) => <ThreadMessage item={item} user={user} />}
                        />
                        : <Content />
                }
                <View style={[S.PH30, S.PV15]}>
                    <ChatInput value={message} onChangeText={setMessage} sendMessage={sendMessage} />
                </View>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    avatar2Cover: {
        marginLeft: -normalize(25),
    },
})