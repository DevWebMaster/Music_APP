import React, { useEffect, useState } from 'react'
import { StyleSheet, View, Text, Image, TouchableOpacity, ScrollView, ImageBackground } from 'react-native'
import { Container, Content } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import { COLOR, DEV, Images, LAYOUT, Styles } from '../../constants'
import { setNavigator } from '../../redux/services/navigator'
import { Footers } from '../../components'
import { Axios } from '../../redux/services'

export default ({navigation}) =>{
    const [category, setCategory] = useState([])

    const getCategory = async () => {
        const { data } = await Axios().getCategory()
        if (data.status === "success") {
            setCategory(data.result.genresRecords)
        } else {
            setCategory([])
        }
    }

    useEffect(() => {
        getCategory()
        if (navigation) {
            setNavigator(navigation)
        }
    }, [])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={S.PL20}>
                    <View style={[S.Acenter, S.MT20]}>
                        <Image source={Images.Logos} style={S.image}/>
                    </View>
                    <Text style={[S.PT20, S.CLW, S.F18, S.FW700]}>Mentall Relaxation</Text>
                    <Text style={[S.CText3, S.F12, S.FW400, S.MT10, S.MB10]}>Featured Tune</Text>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false}>
                        <View style={S.ROW}>
                            <TouchableOpacity disabled onPress={()=>navigation.navigate('Media2Screen')}>
                                <ImageBackground source={Images.Product1} style={S.Item3}>
                                    <View style={S.Cover}>
                                        <Text style={[S.F24, S.FW400, S.CLW, S.Tcenter, S.PH20]}>Dreamworld’s Best Chef</Text>
                                        <View style={S.newBadge}>
                                            <Text style={[S.F12, S.FW400, S.CLW]}>NEW</Text>
                                        </View>
                                    </View>
                                </ImageBackground>
                            </TouchableOpacity>
                            <TouchableOpacity disabled onPress={()=>navigation.navigate('Media2Screen')}>
                                <ImageBackground source={Images.Product2} style={S.Item3}>
                                    <View style={S.Cover}>
                                        <Text style={[S.F24, S.FW400, S.CLW, S.Tcenter, S.PH20]}>{'Wild\n Freedom'}</Text>
                                        <View style={S.newBadge}>
                                            <Text style={[S.F12, S.FW400, S.CLW]}>NEW</Text>
                                        </View>
                                    </View>
                                </ImageBackground>
                            </TouchableOpacity>
                        </View>
                    </ScrollView>
                    <Text style={[S.PT20, S.CLW, S.F18, S.FW700]}>Sleeping Stories</Text>
                    <Text style={[S.CText3, S.F12, S.FW400, S.MT10, S.MB10]}>Chapter 1 Ep2</Text>
                    <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={S.PB20}>
                        <View style={S.ROW}>
                            {
                                category.map((item, key) => (
                                    <TouchableOpacity key={key} onPress={()=>navigation.navigate('Media2Screen', item)}>
                                        <ImageBackground source={{uri: `${DEV.IMAGE_URL}${item.thumb_img}`}} style={S.Item3}>
                                            <View style={S.Cover}>
                                                <Text style={[S.F24, S.FW400, S.CLW, S.Tcenter, S.PH20]}> {item.name} </Text>
                                                <View style={S.newBadge}>
                                                    <Text style={[S.F12, S.FW400, S.CLW]}>NEW</Text>
                                                </View>
                                            </View>
                                        </ImageBackground>
                                    </TouchableOpacity>
                                ))
                            }
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
    Item3:{
        overflow:'hidden',
        borderRadius:normalize(20),
        width:LAYOUT.window.width*0.5,
        height:LAYOUT.window.width*0.6,
        resizeMode:'contain',
        alignItems:'center',
        marginRight:normalize(15),
    },
    newBadge:{
        backgroundColor:COLOR.greenColor1, 
        borderRadius:normalize(10), 
        position:'absolute', 
        left:normalize(20), 
        top:normalize(20),
        paddingHorizontal:normalize(10)
    },
    Cover:{
        width:'100%', 
        height:'100%', 
        backgroundColor:'rgba(0,0,0,0.6)',
        paddingVertical:normalize(30),
        justifyContent:'flex-end'
    }
})