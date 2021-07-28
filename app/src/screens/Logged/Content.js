import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { StyleSheet, View, Text, TouchableOpacity, FlatList } from 'react-native'
import { Container, Content, Header, Icon, Title } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { useApi } from '../../redux/services'
import { COLOR, LAYOUT, Styles } from '../../constants'
import { setActiveMusic, setAllMusic } from '../../redux/actions/musicActions'
import { ContentItemList, LagePlayerList, PlayerPreview, RecommendedList } from '../../components'

export default ({ navigation, route: { params = {} } }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [recentList, setRecentList] = useState([])
    const [recommendList, setRecommendList] = useState([])
    const [musicsWithGenre, setMusicsWithGenre] = useState([])
    const [refresh, setRefresh] = useState(false)
    const [refreshr, setRefreshr] = useState(false)
    const [refreshre, setRefreshre] = useState(false)

    const getRecentList = async () => {
        setRefreshr(true)
        try {
            const formData = new FormData()
            formData.append('uid', user.id)
            const { data } = await Api.getRecentList(formData)
            if (data.status == "success") {
                setRecentList(data.result.musicRecords)
            } else {
                setRecentList([])
            }
            setRefreshr(false)
        } catch (error) {
            console.log(error)
            setRefreshr(false)
        }
    }

    const getRecommendList = async () => {
        setRefreshre(true)
        try {
            const formData = new FormData()
            formData.append('genreId', params.id)
            formData.append('uid', user.id)
            const { data } = await Api.getRecommendList(formData)
            if (data.status == "Success") {
                setRecommendList(data.result)
            } else {
                setRecommendList([])
            }
            setRefreshre(false)
        } catch (error) {
            console.log(error)
            setRefreshre(false)
        }
    }

    const getMusicsWithGenre = async () => {
        if (user.id && params.id) {
            setRefresh(true)
            const formData = new FormData()
            formData.append('uid', user.id)
            formData.append('genreId', params.id)
            const { data } = await Api.getMusicsWithGenre(formData)
            if (data.status === "success") {
                setMusicsWithGenre(data.result.musicRecords)
            } else {
                setMusicsWithGenre([])
            }
            setRefresh(false)
        }
    }

    const musicPlay = async (item, itemlist) => {
        dispatch(setAllMusic(itemlist))
        dispatch(setActiveMusic(item))
    }

    useEffect(() => {
        getRecentList()
        getRecommendList()
        getMusicsWithGenre()
    }, [])


    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Header style={[S.header, { backgroundColor: '#19304c' }]} androidStatusBarColor={COLOR.blueColor7}>
                    <TouchableOpacity onPress={() => navigation.goBack()}>
                        <Icon type="Entypo" name="chevron-small-left" style={[S.CLW, S.F28]} />
                    </TouchableOpacity>
                    <Title style={[S.CLW, S.FW700, S.FRoboto]}>{params.name}</Title>
                    <View style={{ width: normalize(24) }} />
                </Header>
                <Content contentContainerStyle={[S.PL20, S.PT20, S.PB75]} showsVerticalScrollIndicator={false}>
                    <View style={[S.ROW, S.Jbetween, S.MR20, S.MV10]}>
                        <Text style={[S.CText8, S.F16, S.FW400, S.FRoboto]}>Recently added</Text>
                        <TouchableOpacity style={[S.ROW, S.Acenter]} onPress={() => navigation.navigate('RecentScreen')}>
                            <Text style={[S.CText8, S.F16, S.FW400, S.FRoboto]}>See all </Text>
                            <Icon type="AntDesign" name="right" style={[S.CLW, S.F16]} />
                        </TouchableOpacity>
                    </View>
                    <FlatList
                        horizontal
                        data={recentList.slice(0, 5)}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <LagePlayerList item={item} play={e => musicPlay(e, recentList.slice(0, 5))} />}
                        refreshing={refreshr}
                        onRefresh={getRecentList}
                        showsHorizontalScrollIndicator={false}
                    />
                    <View style={[S.ROW, S.Jbetween, S.MR20, S.MT30, S.MB10]}>
                        <Text style={[S.CText8, S.F16, S.FW400, S.FRoboto]}>Recommended</Text>
                        <TouchableOpacity style={[S.ROW, S.Acenter]} onPress={() => navigation.navigate('UnwiindScreen')}>
                            <Text style={[S.CText8, S.F16, S.FW400, S.FRoboto]}>See all </Text>
                            <Icon type="AntDesign" name="right" style={[S.CLW, S.F16]} />
                        </TouchableOpacity>
                    </View>
                    <FlatList
                        horizontal
                        data={recommendList}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <RecommendedList item={item} play={e => musicPlay(e, recommendList)} />}
                        refreshing={refreshre}
                        onRefresh={getRecommendList}
                        showsHorizontalScrollIndicator={false}
                    />
                    <Text style={[S.MT20, S.MB10, S.MR20, S.CText8, S.F18, S.FW700, S.FRoboto]}>All {params.name}</Text>
                    <FlatList
                        data={musicsWithGenre}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <ContentItemList item={item} play={e => musicPlay(e, recommendList)} />}
                        refreshing={refresh}
                        onRefresh={getMusicsWithGenre}
                        showsVerticalScrollIndicator={false}
                        contentContainerStyle={[S.ROW, S.Jbetween, S.Wrap]}
                    />
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
        borderRadius: normalize(15),
        width: LAYOUT.window.width * 0.38,
        height: LAYOUT.window.width * 0.38,
        paddingHorizontal: normalize(10),
        paddingVertical: normalize(10),
        resizeMode: 'contain',
        justifyContent: 'flex-end',
        marginRight: normalize(15),
    },

    playButton: {
        backgroundColor: 'rgba(0,0,0,0.7)',
        height: normalize(34),
        width: normalize(34),
        borderRadius: normalize(17),
        top: normalize(10),
        right: normalize(10),
        justifyContent: 'center',
        alignItems: 'center',
        position: 'absolute',
    },
})