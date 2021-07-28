import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { Container, Content, Icon } from 'native-base'
import { StyleSheet, View, Text, Image, TouchableOpacity, ScrollView, FlatList, ImageBackground } from 'react-native'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { useApi } from '../../redux/services'
import { COLOR, DEV, Images, LAYOUT, Styles } from '../../constants'
import { setActiveMusic, setAllMusic } from '../../redux/actions/musicActions'
import { CategoryItem, LagePlayerList, PlayerPreview } from '../../components'

export default ({ navigation }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [topMusicList, setTopMusicList] = useState([])
    const [category, setCategory] = useState([])
    const [libraryList, setLibraryList] = useState([])
    const [refresh, setRefresh] = useState(false)

    const getCategory = async () => {
        const { data } = await Api.getCategory()
        if (data.status === "success") {
            setCategory(data.result.genresRecords)
        } else {
            setCategory([])
        }
    }

    const getTopMusicList = async () => {
        setRefresh(true)
        const formData = new FormData()
        formData.append('uid', user.id)
        const { data } = await Api.getTopMusicList(formData)
        if (data.status == "Success") {
            setTopMusicList(data.result)
            setRefresh(false)
        } else {
            setTopMusicList([])
            setRefresh(false)
        }
    }

    const getLibraryList = async () => {
        const { data } = await Api.getLibraryList()
        if (data.status == "success") {
            setLibraryList(data.result.libraryRecords)
        } else {
            setLibraryList([])
        }
    }

    const musicPlay = async (item) => {
        dispatch(setAllMusic(topMusicList))
        dispatch(setActiveMusic(item))
    }

    useEffect(() => {
        getCategory()
        getTopMusicList()
        getLibraryList()
    }, [])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PL20, S.PB75]} showsVerticalScrollIndicator={false}>
                    <View style={[S.Acenter, S.MV20, S.PR20]}>
                        <Image source={Images.Logos} style={S.image} />
                    </View>
                    <Text style={[S.MV10, S.CText8, S.F16, S.FW700, S.FRoboto]}>What category are you looking for?</Text>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        {
                            category.map((item, key) => (
                                <CategoryItem
                                    key={key}
                                    index={key}
                                    item={item}
                                />
                            ))
                        }
                    </ScrollView>
                    <View style={[S.MV10, S.MR20, S.ROW, S.Jbetween]}>
                        <Text style={[S.CText8, S.F16, S.FW400, S.FRoboto]}>Playlists</Text>
                        <TouchableOpacity style={[S.ROW, S.Acenter]} onPress={() => navigation.navigate('UnwiindScreen')}>
                            <Text style={[S.CText8, S.F16, S.FW400, S.FRoboto]}>See all </Text>
                            <Icon type="AntDesign" name="right" style={[S.CLW, S.F16]} />
                        </TouchableOpacity>
                    </View>
                    <FlatList
                        horizontal
                        data={topMusicList}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <LagePlayerList item={item} play={musicPlay} />}
                        refreshing={refresh}
                        onRefresh={getTopMusicList}
                        showsHorizontalScrollIndicator={false}
                    />
                    <Text style={[S.MV10, S.MR20, S.CText8, S.F16, S.FW700, S.FRoboto]}>Library</Text>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        <TouchableOpacity onPress={() => navigation.navigate('FavoritesScreen')}>
                            {
                                libraryList[0]?.thumb_img ?
                                    <ImageBackground source={{ uri: `${DEV.IMAGE_URL}${libraryList[0]?.thumb_img}` }} style={S.Item}>
                                        <Text style={[S.F20, S.FW700, S.CLW, S.FRoboto]}>{libraryList[0]?.name}</Text>
                                    </ImageBackground> :
                                    <View style={S.Item}>
                                        <Text style={[S.F20, S.FW700, S.CLW, S.FRoboto]}>Favourite</Text>
                                    </View>
                            }
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => navigation.navigate('RecentScreen')}>
                            {
                                libraryList[1]?.thumb_img ?
                                    <ImageBackground source={{ uri: `${DEV.IMAGE_URL}${libraryList[1]?.thumb_img}` }} style={S.Item}>
                                        <Text style={[S.F20, S.FW700, S.CLW, S.FRoboto]}>{libraryList[1]?.name}</Text>
                                    </ImageBackground> :
                                    <View style={S.Item}>
                                        <Text style={[S.F20, S.FW700, S.CLW, S.FRoboto]}>Recent</Text>
                                    </View>
                            }
                        </TouchableOpacity>
                    </ScrollView>
                </Content>
                <PlayerPreview />
            </LinearGradient>
        </Container >
    )
}

const S = StyleSheet.create({
    ...Styles,
    Item: {
        overflow: 'hidden',
        borderRadius: normalize(20),
        width: LAYOUT.window.width * 0.5,
        height: LAYOUT.window.width * 0.5,
        paddingVertical: normalize(30),
        resizeMode: 'contain',
        alignItems: 'center',
        justifyContent: 'flex-end',
        marginRight: normalize(15),
    },
})