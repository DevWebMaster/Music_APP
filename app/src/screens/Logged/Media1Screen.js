import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux'
import { StyleSheet, View, Text, Image, TouchableOpacity, ScrollView, ImageBackground, FlatList } from 'react-native'
import { Container, Content, Icon } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { COLOR, DEV, Images, LAYOUT, Styles } from '../../constants'
import { Footers, Loading } from '../../components'
import { Axios } from '../../redux/services'

export default ({navigation}) =>{
    const { user } = useSelector(state => state.auth)
    const [loading, setLoading] = useState(false)
	const [refresh, setRefresh] = useState(false)
    const [category, setCategory] = useState([])
    const [topMusicList, setTopMusicList] = useState([])

    const getCategory = async () => {
        const { data } = await Axios().getCategory()
        if (data.status === "success") {
            setCategory(data.result.genresRecords)
        } else {
            setCategory([])
        }
    }

    const getTopMusicList = async () => {
        const formData = new FormData()
        formData.append('uid', user.id)
        const { data } = await Axios().getTopMusicList(formData)
        if (data.status == "Success") {
            setTopMusicList(data.result)
        } else {
            setTopMusicList([])
        }
    }

    useEffect(() => {
        getCategory()
        getTopMusicList()
    }, [])
    
    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={S.PL20}>
                    <View style={[S.Acenter, S.MV20]}>
                        <Image source={Images.Logos} style={S.image}/>
                    </View>
                    <Text style={[S.CText3, S.F16, S.FW700, S.MT5, S.MB10]}>What category are you looking for?</Text>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        <View style={S.ROW}>
                            {
                                category.map((item, key) => (
                                    <TouchableOpacity onPress={()=>navigation.navigate('Media2Screen')} key={key}>
                                        <LinearGradient
                                            start={[1, 0]} end={[0, 1]} 
                                            style={S.categoryButton}
                                            colors={COLOR[`categoryGColor${key % 3 + 1}`]} 
                                        >
                                            <Text style={S.categoryButtonText}> {item.name} </Text>
                                        </LinearGradient>
                                    </TouchableOpacity>
                                ))
                            }
                        </View>
                    </ScrollView>
                    <View style={[S.ROW, S.MT10, S.MB10, S.MR20, S.Jbetween]}>
                        <Text style={[S.CText3, S.F16, S.FW400]}>Playlists</Text>
                        <TouchableOpacity style={[S.ROW, S.Acenter]} onPress={()=>navigation.navigate('UnwiindScreen')}>
                            <Text style={[S.CText3, S.F16, S.FW400]}>See all </Text>
                            <Icon type="AntDesign" name="right" style={[S.CText3, S.F16]} />
                        </TouchableOpacity>
                    </View>
                    {loading &&  <Loading/>}
                    {!loading && topMusicList.length > 0 && (
                        <FlatList
                            horizontal
                            data={topMusicList}
                            showsVerticalScrollIndicator={false}
                            renderItem={({item}) => (
                                <ImageBackground source={{uri: `${DEV.IMAGE_URL}${item.thumb}`}} style={S.Item}>
                                    <TouchableOpacity style={S.playButton} onPress={()=>navigation.navigate('PlayerScreen', item)}>
                                        <Icon type="MaterialCommunityIcons" name="play" style={[S.F24, S.CLW]}/>
                                    </TouchableOpacity>
                                    <View>
                                        <Text style={[S.F14, S.FW700, S.CLW]}> {item.name} </Text>
                                        <Text style={[S.F12, S.FW400, S.CLW]}> {item.description} </Text>
                                    </View>
                                </ImageBackground>
                            )}
                            refreshing={refresh}
                            onRefresh={getTopMusicList}
                            keyExtractor={(item, index) => `${index}` }
                        />
                    )}
                    {/* <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        <View style={S.ROW}>
                            <ImageBackground source={Images.Category1} style={S.Item}>
                                <TouchableOpacity style={S.playButton} onPress={()=>navigation.navigate('PlayerScreen')}>
                                    <Icon type="MaterialCommunityIcons" name="play" style={[S.F24, S.CLW]}/>
                                </TouchableOpacity>
                                <View>
                                    <Text style={[S.F20, S.FW700, S.CLW]}>Kings of Leon</Text>
                                    <Text style={[S.F12, S.FW400, S.CLW]}>When you see yourself</Text>
                                </View>
                            </ImageBackground>
                            <ImageBackground source={Images.Category2} style={S.Item}>
                                <TouchableOpacity style={S.playButton} onPress={()=>navigation.navigate('PlayerScreen')}>
                                    <Icon type="MaterialCommunityIcons" name="play" style={[S.F24, S.CLW]}/>
                                </TouchableOpacity>
                                <View>
                                    <Text style={[S.F20, S.FW700, S.CLW]}>Kings of Leon</Text>
                                    <Text style={[S.F12, S.FW400, S.CLW]}>When you see yourself</Text>
                                </View>
                            </ImageBackground>
                            <ImageBackground source={Images.Category1} style={S.Item}>
                                <TouchableOpacity style={S.playButton} onPress={()=>navigation.navigate('PlayerScreen')}>
                                    <Icon type="MaterialCommunityIcons" name="play" style={[S.F24, S.CLW]}/>
                                </TouchableOpacity>
                                <View>
                                    <Text style={[S.F20, S.FW700, S.CLW]}>Kings of Leon</Text>
                                    <Text style={[S.F12, S.FW400, S.CLW]}>When you see yourself</Text>
                                </View>
                            </ImageBackground>
                        </View>
                    </ScrollView> */}
                    <View style={[S.MT20, S.MB10, S.MR20, S.Jbetween]}>
                        <Text style={[S.CText3, S.F16, S.FW400]}>Library</Text>
                    </View>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        <View style={S.ROW}>
                        <TouchableOpacity onPress={()=>navigation.navigate('Media2Screen')}>
                            <ImageBackground source={Images.Favorites} style={S.Item2}>
                                    <Text style={[S.F20, S.FW700, S.CLW]}>Favorites</Text>
                            </ImageBackground>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={()=>navigation.navigate('Media2Screen')}>
                            <ImageBackground source={Images.Recent} style={S.Item2}>
                                    <Text style={[S.F20, S.FW700, S.CLW]}>Recent</Text>
                            </ImageBackground>
                        </TouchableOpacity>
                        </View>
                    </ScrollView>
                </Content>
                <Footers/>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    categoryButton:{
        marginRight:normalize(10),
        height:normalize(65),
        width:normalize(160),
        paddingHorizontal:normalize(20),
        borderRadius: normalize(10),
        alignItems:'flex-start',
        justifyContent:'center',
    },
    categoryButtonText:{    
        color:COLOR.whiteColor, 
        fontSize:normalize(16),
        fontWeight:'700',
        textAlign:'center',
    },
    Item:{
        overflow:'hidden',
        borderRadius:normalize(20),
        width:LAYOUT.window.width*0.38,
        height:LAYOUT.window.width*0.38,
        paddingHorizontal:normalize(10),
        paddingVertical:normalize(10),
        resizeMode:'contain',
        justifyContent:'flex-end',
        marginRight:normalize(15),
    },
    Item2:{
        overflow:'hidden',
        borderRadius:normalize(20),
        width:LAYOUT.window.width*0.5,
        height:LAYOUT.window.width*0.5,
        paddingVertical:normalize(30),
        resizeMode:'contain',
        alignItems:'center',
        justifyContent:'flex-end',
        marginRight:normalize(15),
    },
    playButton:{
        backgroundColor:'rgba(0,0,0,0.7)',
        height:normalize(34),
        width:normalize(34),
        borderRadius:normalize(17),
        top:normalize(10),
        right:normalize(10),
        justifyContent:'center',
        alignItems:'center',
        position:'absolute',
    }
})