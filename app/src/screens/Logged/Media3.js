import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { StyleSheet, View, Text, Image, TouchableOpacity, FlatList } from 'react-native'
import { Container, Icon, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { useApi } from '../../redux/services'
import { COLOR, DEV, Styles } from '../../constants'
import { PlayerList, PlayerPreview } from '../../components'
import { setActiveMusic, setAllMusic } from '../../redux/actions/musicActions'

export default ({ navigation, route: { params = {} } }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [musicsWithArtist, setMusicsWithArtist] = useState([])
    const [refresh, setRefresh] = useState(false)

    const getMusicsWithArtist = async () => {
        if (user.id && params.id) {
            setRefresh(true)
            const formData = new FormData()
            formData.append('uid', user.id)
            formData.append('djId', params.id)
            const { data } = await Api.getMusicsWithArtist(formData)
            if (data.status === "success") {
                setMusicsWithArtist(data.result.musicRecords)
            } else {
                setMusicsWithArtist([])
            }
            setRefresh(false)
        }
    }

    const musicPlay = async (item) => {
        dispatch(setAllMusic(musicsWithArtist))
        dispatch(setActiveMusic(item))
    }

    useEffect(() => {
        getMusicsWithArtist()
    }, [])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PH20, S.PB75]} showsVerticalScrollIndicator={false}>
                    <View style={[S.ROW, S.Jbetween, S.MT20]}>
                        <TouchableOpacity onPress={() => navigation.goBack()}>
                            <Icon type="AntDesign" name="arrowleft" style={[S.CLW, S.F24]} />
                        </TouchableOpacity>
                        <View style={[S.Acenter, S.imageCover]}>
                            <Image source={{ uri: `${DEV.IMAGE_URL}${params.profile_cover}` }} style={S.image} />
                        </View>
                        <View style={{ width: normalize(24) }} />
                    </View>
                    <Text style={[S.MV10, S.Tcenter, S.F16, S.FW700, S.FRoboto, S.CLW]}>{params.email}</Text>
                    <Text style={[S.MB10, S.Tcenter, S.F24, S.FW700, S.FRoboto, S.CLW]}>{params.name}</Text>
                    <Text style={[S.MB10, S.Tcenter, S.F12, S.FW400, S.FRoboto, { color: '#8395ab' }]}>{params.mobile}</Text>
                    <FlatList
                        data={musicsWithArtist}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <PlayerList item={item} play={musicPlay} />}
                        refreshing={refresh}
                        onRefresh={getMusicsWithArtist}
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
    image: {
        width: normalize(120),
        height: normalize(120),
    },
    imageCover: {
        borderWidth: normalize(5),
        borderColor: COLOR.whiteColor,
        borderRadius: normalize(100),
        height: normalize(120),
        width: normalize(120),
        overflow: 'hidden',
        alignItems: 'center',
        justifyContent: 'center',
    }
})