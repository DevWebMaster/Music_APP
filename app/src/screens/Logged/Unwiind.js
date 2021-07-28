import React, { useEffect, useState } from 'react'
import { StyleSheet, FlatList, View, Text, Image } from 'react-native'
import { Container, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import { useApi } from '../../redux/services'
import { COLOR, Images, Styles } from '../../constants'
import { setNavigator } from '../../redux/services/navigator'
import { FirstPlayerList, PlayerPreview } from '../../components'

export default ({ navigation }) => {
    const Api = useApi()
    const [category, setCategory] = useState([])
    const [refresh, setRefresh] = useState(false)

    const getCategory = async () => {
        setRefresh(true)
        try {
            const { data } = await Api.getCategory()
            if (data.status === "success") {
                setCategory(data.result.genresRecords)
            } else {
                setCategory([])
            }
            setRefresh(false)
        } catch (error) {
            console.log(`getCategory => `, error)
            setRefresh(false)
        }
    }

    useEffect(() => {
        if (navigation)
            setNavigator(navigation)
        getCategory()
    }, [])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={[S.PL20, S.PB75]} showsVerticalScrollIndicator={false}>
                    <View style={[S.Acenter, S.MT20, S.PR20]}>
                        <Image source={Images.Logos} style={S.image} />
                    </View>
                    <Text style={[S.MT20, S.CLW, S.F20, S.FW700, S.FRoboto]}>Mentall Relaxation</Text>
                    <Text style={[S.MV10, S.CText3, S.F12, S.FW400, S.FRoboto]}>Featured Tune</Text>
                    <FlatList
                        horizontal
                        data={category}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <FirstPlayerList item={item} />}
                        refreshing={refresh}
                        onRefresh={getCategory}
                        showsHorizontalScrollIndicator={false}
                    />
                    <Text style={[S.PT20, S.CLW, S.F20, S.FW700, S.FRoboto]}>Sleeping Stories</Text>
                    <Text style={[S.MV10, S.CText3, S.F12, S.FW400, S.FRoboto]}>Chapter 1 Ep2</Text>
                    <FlatList
                        horizontal
                        data={category}
                        keyExtractor={(item, index) => `${index}`}
                        renderItem={({ item }) => <FirstPlayerList item={item} />}
                        refreshing={refresh}
                        onRefresh={getCategory}
                        showsHorizontalScrollIndicator={false}
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