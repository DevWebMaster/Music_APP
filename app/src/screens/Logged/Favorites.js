import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { StyleSheet, TouchableOpacity, FlatList } from 'react-native'
import { Container, Icon, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { useApi } from '../../redux/services'
import { COLOR, Styles } from '../../constants'
import { PlayerList, PlayerPreview } from '../../components'
import { setActiveMusic, setAllMusic } from '../../redux/actions/musicActions'

export default ({ navigation }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [topMusicList, setTopMusicList] = useState([])
    const [refresh, setRefresh] = useState(false)

    const getTopMusicList = async () => {
        setRefresh(true)
        try {
            const formData = new FormData()
            formData.append('uid', user.id)
            const { data } = await Api.getTopMusicList(formData)
            if (data.status == "Success") {
                setTopMusicList(data.result)
            } else {
                setTopMusicList([])
            }
            setRefresh(false)
        } catch (error) {
            console.log(error)
            setRefresh(false)
        }
    }

    const musicPlay = async (item) => {
        dispatch(setAllMusic(topMusicList))
        dispatch(setActiveMusic(item))
    }

    useEffect(() => {
        getTopMusicList()
    }, [navigation])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PB75]} showsVerticalScrollIndicator={false}>
                    <TouchableOpacity style={[S.MT20, S.ML20]} onPress={() => navigation.goBack()}>
                        <Icon type="AntDesign" name="arrowleft" style={[S.CLW, S.F24]} />
                    </TouchableOpacity>
                    <FlatList
                        data={topMusicList}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <PlayerList item={item} play={musicPlay} />}
                        refreshing={refresh}
                        onRefresh={getTopMusicList}
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