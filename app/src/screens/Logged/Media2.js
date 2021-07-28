import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { FlatList, StyleSheet, View, Text, Image, ScrollView } from 'react-native'
import { Container, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import { useApi } from '../../redux/services'
import { COLOR, Images, Styles } from '../../constants'
import { setActiveMusic, setAllMusic } from '../../redux/actions/musicActions'
import { AlbumItem, PlayerList, PlayerPreview, SecondCategoryItem } from '../../components'

export default ({ navigation, route: { params = {} } }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [categoryActive, setCategoryActive] = useState(params)
    const [musicsWithGenre, setMusicsWithGenre] = useState([])
    const [category, setCategory] = useState([])
    const [artist, setArtist] = useState([])
    const [arefresh, setARefresh] = useState(false)
    const [refresh, setRefresh] = useState(false)

    const getCategory = async () => {
        const { data } = await Api.getCategory()
        if (data.status === "success") {
            const result = data.result.genresRecords
            setCategory(result)
            if (Object.keys(categoryActive) == 0 && result && result.length) {
                setCategoryActive(result[0])
            }
        } else {
            setCategory([])
        }
    }

    const getMusicsWithGenre = async () => {
        if (user.id && categoryActive.id) {
            setRefresh(true)
            const formData = new FormData()
            formData.append('uid', user.id)
            formData.append('genreId', categoryActive.id)
            const { data } = await Api.getMusicsWithGenre(formData)
            if (data.status === "success") {
                setMusicsWithGenre(data.result.musicRecords)
            } else {
                setMusicsWithGenre([])
            }
            setRefresh(false)
        }
    }

    const getArtist = async () => {
        setARefresh(true)
        const { data } = await Api.getArtist()
        if (data.status === "success") {
            setArtist(data.result.djsRecords)
        } else {
            setArtist([])
        }
        setARefresh(false)
    }

    const musicPlay = async (item) => {
        dispatch(setAllMusic(musicsWithGenre))
        dispatch(setActiveMusic(item))
    }

    useEffect(() => {
        getArtist()
        getCategory()
        getMusicsWithGenre()
    }, [navigation])

    useEffect(() => {
        getMusicsWithGenre()
    }, [categoryActive])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PL20, S.PB75]} showsVerticalScrollIndicator={false}>
                    <View style={[S.Acenter, S.MT20, S.MB20, S.PR20]}>
                        <Image source={Images.Logos} style={S.image} />
                    </View>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        {
                            category.map((item, key) => (
                                <SecondCategoryItem
                                    key={key}
                                    item={item}
                                    active={categoryActive}
                                    setActive={setCategoryActive}
                                />
                            ))
                        }
                    </ScrollView>
                    <Text style={[S.MV10, S.CText8, S.F16, S.FW700, S.FRoboto]}>Popular Albums</Text>
                    <FlatList
                        horizontal
                        data={artist}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <AlbumItem item={item} />}
                        refreshing={arefresh}
                        onRefresh={getArtist}
                        showsHorizontalScrollIndicator={false}
                    />
                    <Text style={[S.MV10, S.CText8, S.F16, S.FW700, S.FRoboto]}>Popular Tracks</Text>
                    <FlatList
                        data={musicsWithGenre}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <PlayerList item={item} play={musicPlay} />}
                        refreshing={refresh}
                        onRefresh={getMusicsWithGenre}
                        showsVerticalScrollIndicator={false}
                    />
                </Content>
                <PlayerPreview />
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles
})