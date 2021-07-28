import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux'
import { StyleSheet, View, Text, Image, ScrollView, FlatList } from 'react-native'
import { Container, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import { useApi } from '../../redux/services'
import { COLOR, Database, Images, Styles } from '../../constants'
import { ForumCategoryItem, ForumItem, PlayerPreview } from '../../components'

export default ({ navigation }) => {
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const [categoryActive, setCategoryActive] = useState(null)
    const [musicsWithGenre, setMusicsWithGenre] = useState([])
    const [category, setCategory] = useState([])
    const [members, setMembers] = useState([])
    const [refresh, setRefresh] = useState(false)

    const getCategory = async () => {
        const { data } = await Api.getCategory()
        if (data.status === "success") {
            setCategory(data.result.genresRecords)
            if (data.result.genresRecords && data.result.genresRecords.length) {
                setCategoryActive(data.result.genresRecords[0].id)
            }
        } else {
            setCategory([])
        }
    }

    const getMusicsWithGenre = async () => {
        if (user.id && categoryActive) {
            setRefresh(true)
            Database.ref(`users`).on('value', async snapshot => {
                setMembers(snapshot.val())
            })
            const formData = new FormData()
            formData.append('uid', user.id)
            formData.append('genreId', categoryActive)
            const { data } = await Api.getMusicsWithGenre(formData)
            if (data.status === "success") {
                setMusicsWithGenre(data.result.musicRecords)
            } else {
                setMusicsWithGenre([])
            }
            setRefresh(false)
        }
    }

    const onLikeMusic = async (item) => {
        const formData = new FormData()
        formData.append('email', user.email)
        formData.append('music_id', item.id)
        if (item.is_liked == '1') {
            const { data } = await Api.dislikMusic(formData)
            if (data.status === "success") {
                getMusicsWithGenre()
            }
        } else {
            const { data } = await Api.likeMusic(formData)
            if (data.status === "success") {
                getMusicsWithGenre()
            }
        }
    }

    useEffect(() => {
        getCategory()
    }, [navigation])

    useEffect(() => {
        getMusicsWithGenre()
    }, [categoryActive])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PB75]} showsVerticalScrollIndicator={false}>
                    <Image source={Images.Logos} style={[S.image, S.Ascenter, S.MT20]} />
                    <View style={[S.PL20]}>
                        <Text style={[S.MT20, S.CLW, S.F26, S.FW700, S.FRoboto]}>Forum</Text>
                        <ScrollView style={[S.MT30]} horizontal showsHorizontalScrollIndicator={false}>
                            {
                                category.map((item, key) => (
                                    <ForumCategoryItem
                                        key={key}
                                        item={item}
                                        active={categoryActive}
                                        setActive={setCategoryActive}
                                    />
                                ))
                            }
                        </ScrollView>
                    </View>
                    <FlatList
                        data={musicsWithGenre}
                        refreshing={refresh}
                        onRefresh={getMusicsWithGenre}
                        keyExtractor={(item, index) => `${index}`}
                        contentContainerStyle={S.PH20}
                        showsVerticalScrollIndicator={false}
                        renderItem={({ item }) => <ForumItem item={item} onLike={onLikeMusic} members={members} />}
                    />
                </Content>
                <PlayerPreview />
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
})