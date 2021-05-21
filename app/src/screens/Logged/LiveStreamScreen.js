import React, { useState } from 'react'
import { StyleSheet, View, Text, Image, TouchableOpacity, ScrollView, ImageBackground, TextInput } from 'react-native'
import { Container, Content, Icon } from 'native-base'
import normalize from 'react-native-normalize'
import * as Progress from 'react-native-progress'
import { Flow } from 'react-native-animated-spinkit'
import { COLOR, Images, LAYOUT, Styles } from '../../constants'
import { Footers } from '../../components'

export default () =>{
    const [message, setMessage] = useState("Long live the King!")
    return (
        <Container>
            <ImageBackground source={Images.Live} style={[S.W100P, S.H100P, {resizeMode:'contain'}]}>
                <View style={[S.ROW, S.Jbetween, S.Acenter, S.PH20, S.PT25, ]}>
                    <TouchableOpacity style={S.backIcon}>
                        <Icon type="AntDesign" name="left"  style={[S.CLW, S.F24]}/>
                    </TouchableOpacity>
                    <View>
                        <Text style={[S.liveBadge, S.F12, S.FW400, S.CLW]}>LIVE</Text>
                    </View>
                </View>
                <Content>
                    
                </Content>
                <View style={[S.Acenter, S.MV15, S.ROW, S.Jcenter]}>
                    <Text style={[S.CLW, S.F14, S.FW400, S.PR10]}>3:01</Text>
                    <Progress.Bar 
                        progress={0.55} 
                        borderWidth={0} 
                        color={COLOR.redColor3} 
                        width={LAYOUT.window.width-normalize(120)} 
                        style={{backgroundColor:COLOR.greyColor2}}
                    />
                    <TouchableOpacity>
                        <Icon type="FontAwesome" name="expand" style={[S.PL20, S.CLW, S.F20]}/>
                    </TouchableOpacity>
                </View>
                <View style={S.chatCover}>
                    <View style={[S.ROW, S.Jbetween]}>
                        <Text style={[S.CLW, S.F14, S.FW400, S.PR10]}>280 people arewatching</Text>
                        <TouchableOpacity>
                            <Icon type="AntDesign" name="hearto" style={[S.F22, S.CLW]} />
                        </TouchableOpacity>
                    </View>
                    <ScrollView>
                        <View style={[S.MessageCover]}>
                            <View style={S.userAvatar}>
                                <Text style={[S.F20, S.CLW]}>M</Text>
                            </View>
                            <View style={S.textCover}>
                                <Text style={[S.F12, S.CLW]}>It’s amazing to see him live 😀</Text>
                            </View>
                        </View>
                        <View style={[S.MessageCover]}>
                            <View style={[S.userAvatar,{backgroundColor:'#dc5931'}]}>
                                <Text style={[S.F20, S.CLW]}>T</Text>
                            </View>
                            <View style={S.textCover}>
                                <Text style={[S.F12, S.CLW]}>There are not enough words to describe how AMAZING this was, thank you TOMORROWLAND!!</Text>
                            </View>
                        </View>
                        <View style={[S.MessageCover]}>
                            <View style={S.userAvatar}>
                                <Text style={[S.F20, S.CLW]}>M</Text>
                            </View>
                            <View style={S.textCover}>
                                <Flow size={normalize(30)} color={COLOR.whiteColor}/>
                            </View>
                        </View>
                        <View style={[S.W100P, S.MT20, S.Hidden, {borderRadius:normalize(50)}]}>
                            <TextInput
                                value={message}
                                onChangeText={(e)=>setMessage(e)}
                                style={S.messageInput}
                            />
                            <TouchableOpacity style={[{position:'absolute', right:-normalize(10)}, S.Acenter, S.Jcenter]}>
                                <Image source={Images.Button} style={{height:normalize(45), width:normalize(80), resizeMode:'contain'}}/>
                                <Icon type="MaterialIcons" name="send" style={[S.CLW, S.F22, {position:'absolute', left:normalize(35)}]}/>
                            </TouchableOpacity>
                        </View>
                    </ScrollView>
                </View>
                <Footers/>
            </ImageBackground>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    liveBadge:{
        backgroundColor:COLOR.redColor2, 
        borderRadius:normalize(10), 
        paddingHorizontal:normalize(10)
    },
    chatCover:{
        paddingHorizontal:normalize(30),
        paddingTop:normalize(30),
        width:'100%',
        height:LAYOUT.window.height*0.45,
        borderTopRightRadius:normalize(20),
        borderTopLeftRadius:normalize(20),
        backgroundColor:'rgba(255,255,255,0.2)',
    },
    userAvatar:{
        height:normalize(35),
        width:normalize(35),
        borderRadius:normalize(25),
        justifyContent:'center',
        alignItems:'center',
        backgroundColor:COLOR.blueColor1
    },
    textCover:{
        maxWidth:LAYOUT.window.width*0.6,
        minHeight:normalize(35),
        marginLeft:normalize(10),
        paddingVertical:normalize(12),
        paddingHorizontal:normalize(20),
        borderRadius:normalize(25),
        justifyContent:'center',
        backgroundColor:COLOR.greyColor3
    },
    MessageCover:{
        marginTop:normalize(10),
        flexDirection:'row',
        alignItems:'flex-start'
    },
    messageInput:{
        height:normalize(45),
        borderRadius:normalize(50),
        paddingHorizontal:normalize(20),
        backgroundColor:COLOR.greyColor3,
        fontSize:normalize(13),
        color:COLOR.whiteColor,
    }
})