import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux'
import { FlatList, StyleSheet, View, Text, Image, TouchableOpacity, ScrollView } from 'react-native'
import { Container, Content, Icon } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { COLOR, DEV, Images, LAYOUT, Styles } from '../../constants'
import { Footers, Loading } from '../../components'
import { Axios } from '../../redux/services'
import { Fragment } from 'react'

export default ({navigation}) =>{
    const categoryItem = navigation.state.params
    const { user } = useSelector(state => state.auth)
    const [loading, setLoading] = useState(false)
	const [refresh, setRefresh] = useState(false)
    const [aloading, setALoading] = useState(false)
	const [arefresh, setARefresh] = useState(false)
    const [category, setCategory] = useState([])
    const [musicsWithGenre, setMusicsWithGenre] = useState([])
    const [artist, setArtist] = useState([])

    const getCategory = async () => {
        const { data } = await Axios().getCategory()
        if (data.status === "success") {
            setCategory(data.result.genresRecords)
        } else {
            setCategory([])
        }
    }

    const getMusicsWithGenre = async () => {
        if(user.id && categoryItem.id){
            setLoading(true)
            setRefresh(true)
            const formData = new FormData()
            formData.append('uid', user.id)
            formData.append('genreId', categoryItem.id)
            const { data } = await Axios().getMusicsWithGenre(formData)
            if (data.status === "success") {
                setMusicsWithGenre(data.result.musicRecords)
            } else {
                setMusicsWithGenre([])
            }
            setLoading(false)
            setRefresh(false)
        }
    }

    const getArtist = async () => {
        setALoading(true)
        setARefresh(true)
        const { data } = await Axios().getArtist()
        if (data.status === "success") {
            setArtist(data.result.djsRecords)
        } else {
            setArtist([])
        }
        setALoading(false)
        setARefresh(false)
    }
    

    useEffect(() => {
        getCategory()
        getMusicsWithGenre()
        getArtist()
    }, [navigation])
    
    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={S.PL20}>
                    <View style={[S.Acenter, S.MT20, S.MB20]}>
                        <Image source={Images.Logos} style={S.image}/>
                    </View>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        <View style={S.ROW}>
                            {
                                category.map((item, key) => (
                                    <TouchableOpacity key={key} onPress={()=>navigation.navigate('Media2Screen', item)}>
                                        {
                                            item.id == categoryItem.id ? 
                                            <Fragment>
                                                <Text style={[S.CLBule4, S.F16, S.FW400, S.MR20]}> {item.name} </Text>
                                                <Icon type="Entypo" name="dot-single" style={S.point} />
                                            </Fragment>:
                                            <Text style={[S.CLW, S.F16, S.FW400, S.MR20]}> {item.name} </Text>
                                        }
                                    </TouchableOpacity>
                                ))
                            }
                        </View>
                    </ScrollView>
                    <Text style={[S.CText3, S.F16, S.FW700, S.MT10, S.MB10]}>Popular Albums</Text>
                    {aloading &&  <Loading/>}
                    {!aloading && artist.length > 0 && (
                        <FlatList
                            data={artist}
                            showsVerticalScrollIndicator={false}
                            horizontal
                            renderItem={({item}) => (
                                <TouchableOpacity onPress={()=>navigation.navigate('Media3Screen', item)}>
                                    <Image source={{uri:`${DEV.IMAGE_URL}${item.avatar_url}`}} style={S.PlayerItem}/>
                                    <View style={[S.ROW, S.Jcenter, S.MT10]}>
                                        <Text style={[S.F12, S.FW400, S.CLW]}>{item.name}</Text>
                                        <Text style={[S.F12, S.FW400, S.CLBule1, S.PH15]}>|</Text>
                                        <Text style={[S.F12, S.FW400, S.CLW]}>{item.email}</Text>
                                    </View>
                                </TouchableOpacity>
                            )}
                            refreshing={arefresh}
                            onRefresh={getArtist}
                            keyExtractor={(item, index) => `${index}` }
                        />
                    )}
                    <Text style={[S.CText3, S.F16, S.FW700, S.MT10, S.MB10]}>Popular Tracks</Text>
                    {loading &&  <Loading/>}
                    {!loading && musicsWithGenre.length > 0 && (
                            <FlatList
                                data={musicsWithGenre}
                                showsVerticalScrollIndicator={false}
                                renderItem={({item}) => (
                                    <View style={[S.ROW, S.Acenter, S.Jbetween, S.MT10, {width:LAYOUT.window.width-normalize(40)}]}>
                                        <View style={[S.ROW, S.Acenter]}>
                                            <Image source={{uri: `${DEV.IMAGE_URL}${item.thumb}`}} style={S.PlayerItems}/>
                                            <View style={S.PL10}> 
                                                <Text style={[S.F14, S.FW700, S.CLW]}> {item.name} </Text>
                                                <Text style={[S.F12, S.FW400, S.CLW]}> {item.playCounts} Listens </Text>
                                            </View>
                                        </View>
                                        <View style={[S.ROW, S.Acenter]}>
                                            <Text style={[S.F14, S.FW700, S.CLW, S.MR20]}> {item.duration} </Text>
                                            <TouchableOpacity style={S.playButton} onPress={()=>navigation.navigate('PlayerScreen', item)}>
                                                <Icon type="MaterialCommunityIcons" name="play" style={[S.F24, S.CLBule2]}/>
                                            </TouchableOpacity>
                                        </View>
                                    </View>
                                )}
                                refreshing={refresh}
                                onRefresh={getMusicsWithGenre}
                                keyExtractor={(item, index) => `${index}` }
                            />
                    )}
                </Content>
                <Footers/>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    PlayerItem:{
        overflow:'hidden',
        borderRadius:normalize(10),
        width:LAYOUT.window.width*0.7,
        height:LAYOUT.window.width*0.38,
        paddingHorizontal:normalize(10),
        paddingVertical:normalize(10),
        resizeMode:'cover',
        justifyContent:'flex-end',
        marginRight:normalize(15),
    },
    PlayerItems:{
        overflow:'hidden',
        borderRadius:normalize(10),
        height:normalize(55),
        width:normalize(55),
        resizeMode:'contain',
    },
    PlayerItemdefults:{
        overflow:'hidden',
        borderRadius:normalize(10),
        height:normalize(55),
        width:normalize(55),
        justifyContent:'center',
        alignItems:'center',
        backgroundColor:'#cfd8dc'
    },
    playButton:{
        backgroundColor:COLOR.blueColor3,
        height:normalize(26),
        width:normalize(26),
        borderRadius:normalize(13),
        justifyContent:'center',
        alignItems:'center',
    },
    point:{
        position:'absolute',
        top:-normalize(10),
        right:-normalize(5),
        color:COLOR.blueColor4
    },
})