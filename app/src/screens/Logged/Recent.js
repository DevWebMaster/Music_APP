import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { StyleSheet, View, Text, Image, TouchableOpacity, FlatList } from 'react-native'
import { Container, Icon, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { COLOR, DEV, LAYOUT, Styles } from '../../constants'
import { PlayerList, PlayerPreview } from '../../components'
import { useApi } from '../../redux/services'
import { setActiveMusic, setAllMusic } from '../../redux/actions/musicActions'

export default ({ navigation }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [recentList, setRecentList] = useState([])
    const [refresh, setRefresh] = useState(false)

    const getRecentList = async () => {
        setRefresh(true)
        try {
            const formData = new FormData()
            formData.append('uid', user.id)
            console.log(user.id)
            const { data } = await Api.getRecentList(formData)
            if (data.status == "success") {
                setRecentList(data.result.musicRecords)
            } else {
                setRecentList([])
            }
            setRefresh(false)
        } catch (error) {
            console.log(error)
            setRefresh(false)
        }
    }

    const musicPlay = async (item) => {
        dispatch(setAllMusic(recentList))
        dispatch(setActiveMusic(item))
    }

    useEffect(() => {
        getRecentList()
    }, [navigation])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PB75]} showsVerticalScrollIndicator={false}>
                    <TouchableOpacity style={[S.MT20, S.ML20]} onPress={() => navigation.goBack()}>
                        <Icon type="AntDesign" name="arrowleft" style={[S.CLW, S.F24]} />
                    </TouchableOpacity>
                    <FlatList
                        data={recentList}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <PlayerList item={item} play={musicPlay} />}
                        refreshing={refresh}
                        onRefresh={getRecentList}
                        contentContainerStyle={[S.PH20]}
                        showsVerticalScrollIndicator={false}
                    />
                </Content>
                <PlayerPreview />
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    playButton: {
        backgroundColor: COLOR.blueColor3,
        height: normalize(26),
        width: normalize(26),
        borderRadius: normalize(13),
        justifyContent: 'center',
        alignItems: 'center',
    }
})