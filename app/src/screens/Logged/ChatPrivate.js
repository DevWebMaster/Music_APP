import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux'
import { FlatList, StyleSheet, View, TouchableOpacity } from 'react-native'
import { Container, Content, Header, Icon, Title } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import { COLOR, Database, Styles } from '../../constants'
import { ChatInput, PrivateMessage, UserAvatars, Footers } from '../../components'

export default ({ navigation, route }) => {
    const { user } = useSelector(state => state.auth)
    const userData = route.params
    const [messageList, setMessageList] = useState({})
    const [message, setMessage] = useState('')
    let flatList = null

    const sendMessage = () => {
        if (message != '') {
            const data = { message, email: user.email, sender: user.id, receiver: userData.user, createdAt: new Date().valueOf(), avatar: user.profile_avatar ? user.profile_avatar : '' }
            Database.ref(`private-message`).push(data).then(e => {
                setMessage('')
            }).catch(error => {
                console.log(error)
            })
        }
    }

    const loadMessage = async () => {
        Database.ref(`private-message`).on('value', async snapshot => {
            setMessageList(snapshot.val())
        })
    }

    useEffect(() => {
        loadMessage()
    }, [navigation])


    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient1}>
                <Header style={[S.header]} androidStatusBarColor={COLOR.StatusBarColor}>
                    <View style={[{ width: '20%' }]}>
                        <TouchableOpacity onPress={() => navigation.goBack()}>
                            <Icon type="Entypo" name="chevron-small-left" style={[S.CLW, S.F28]} />
                        </TouchableOpacity>
                    </View>
                    <Title style={[S.CLW, S.FW700, S.FRoboto, S.Tcenter, { width: '60%' }]}>{userData.username}</Title>
                    <View style={[S.ROW, S.PV10, S.Jend, { width: '20%' }]}>
                        <UserAvatars user={userData} />
                    </View>
                </Header>
                {
                    messageList ?
                        <FlatList
                            data={Object.values(messageList)}
                            keyExtractor={(item, index) => `${index}`}
                            renderItem={({ item }) => <PrivateMessage item={item} user={user} userData={userData} />}
                            ref={ref => flatList = ref}
                            onContentSizeChange={() => flatList.scrollToEnd()}
                            showsVerticalScrollIndicator={false}
                            style={[S.PH20]}
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
})