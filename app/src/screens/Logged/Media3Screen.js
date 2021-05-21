import React, { useEffect, useState } from 'react'
import { StyleSheet, View, Text, Image, TouchableOpacity, FlatList } from 'react-native'
import { Container, Content, Icon } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { COLOR, DEV, LAYOUT, Styles } from '../../constants'
import { Footers, Loading } from '../../components'
import { useSelector } from 'react-redux'
import { Axios } from '../../redux/services'

export default ({navigation}) =>{
    const categoryItem = navigation.state.params
    const { user } = useSelector(state => state.auth)
    const [loading, setLoading] = useState(false)
	const [refresh, setRefresh] = useState(false)
    const [musicsWithArtist, setMusicsWithArtist] = useState([])

    const getMusicsWithArtist = async () => {
        if(user.id && categoryItem.id){
            setLoading(true)
            setRefresh(true)
            const formData = new FormData()
            formData.append('uid', user.id)
            formData.append('djId', categoryItem.id)
            const { data } = await Axios().getMusicsWithArtist(formData)
            if (data.status === "success") {
                setMusicsWithArtist(data.result.musicRecords)
            } else {
                setMusicsWithArtist([])
            }
            setLoading(false)
            setRefresh(false)
        }
    }

    useEffect(() => {
        getMusicsWithArtist()
    }, [])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={S.PL20}>
                    <TouchableOpacity style={S.backIcon} onPress={()=>navigation.goBack()}>
                        <Icon type="AntDesign" name="arrowleft"  style={[S.CLW, S.F24]}/>
                    </TouchableOpacity>
                    <View style={S.Acenter}>
                        <View style={[S.Acenter, S.MT20, S.imageCover]}>
                            <Image source={{uri: `${DEV.IMAGE_URL}${categoryItem.profile_cover}`}} style={S.image}/>
                        </View>
                    </View>
                    <Text style={[S.CLW, S.Tcenter, S.F16, S.FW700, S.MT10, S.MB10]}>{categoryItem.email}</Text>
                    <Text style={[S.CLW, S.Tcenter, S.F24, S.FW700, S.MB10]}>{categoryItem.name}</Text>
                    <Text style={[S.CLW, S.Tcenter, S.F12, S.FW400, S.MB10]}>{categoryItem.mobile}</Text>
                    {loading &&  <Loading/>}
                    {!loading && musicsWithArtist.length > 0 && (
                        <FlatList
                            data={musicsWithArtist}
                            showsVerticalScrollIndicator={false}
                            renderItem={({item}) => (
                                <View style={[S.ROW, S.Acenter, S.Jbetween, S.MT15, {width:LAYOUT.window.width-normalize(40)}]}>
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
                            onRefresh={getMusicsWithArtist}
                            keyExtractor={(item, index) => `${index}` }
                        />
                    )}
                </Content>
                {/* <View style={[S.FooterPlayer]}>
                    <View style={[S.ROW, S.Acenter]}>
                        <Image source={Images.PlayerItem3} style={S.PlayerItems}/>
                        <View style={S.PL10}> 
                            <Text style={[S.F14, S.FW700, S.CLW]}>When She’s Around</Text>
                            <Text style={[S.F12, S.FW400, S.CLW]}>Deveedaas Nan..</Text>
                        </View>
                    </View>
                    <View style={[S.ROW, S.Acenter]}>
                        <TouchableOpacity>
                            <Icon type="AntDesign" name="pause" style={[S.F26, S.CLW, S.MR10]}/>
                        </TouchableOpacity>
                        <TouchableOpacity>
                            <Icon type="MaterialIcons" name="close" style={[S.F26, S.CLW]}/>
                        </TouchableOpacity>
                    </View>
                </View> */}
                <Footers/>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
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
    image:{
        width:normalize(120),
        height:normalize(120),
    },
    imageCover:{
        borderWidth:normalize(5),
        borderColor:COLOR.whiteColor,
        borderRadius:normalize(100),
        height:normalize(120),
        width:normalize(120),
        overflow:'hidden',
        alignItems:'center',
        justifyContent:'center',
    },
    FooterPlayer:{
        flexDirection:'row',
        alignItems:'center',
        justifyContent:'space-between',
        width:LAYOUT.window.width, 
        backgroundColor:'rgba(28,51,84,0.8)',
        paddingHorizontal:normalize(20),
        paddingVertical:normalize(10),
    },
    backIcon:{
        position:'absolute',
        top:normalize(20),
        left:normalize(20),
    }
})