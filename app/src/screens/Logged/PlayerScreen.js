import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux'
import { StyleSheet, View, Text, Image, TouchableOpacity } from 'react-native'
import { Container, Content, Icon } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import moment from 'moment'
import * as Progress from 'react-native-progress'
import { Audio } from 'expo-av'
import { COLOR, DEV, LAYOUT, Styles } from '../../constants'
import { Footers } from '../../components'
import { Axios } from '../../redux/services'

export default ({navigation}) =>{
    const item = navigation.state.params
    const { user } = useSelector(state => state.auth)
    const [progress, setProgress] = useState(0)
    const [durationMillis, setDurationMillis] = useState(0)
    const [positionMillis, setPositionMillis] = useState(0)
    const [time, setTime] = useState(new Date())
    const [isPlay, setIsPlay] = useState(false)
    const [isLooping, setIsLooping] = useState(false)
    const [isLike, setIsLike] = useState(item.is_liked==1?true:false)
    const [sound, setSound] = useState(null)
    const [loading, setLoading] = useState(false)

    const stopSound = async () => {
        if(loading){
            await sound.pauseAsync()
            setIsPlay(false)
        }
    }
    
    const playSound = async () => {
        if(!loading){
            return
        }
        if (isPlay) {
            await stopSound()
        } else {
            setIsPlay(true)
            await sound.playAsync()
            sound.setOnPlaybackStatusUpdate((e) => {
                if(e.durationMillis == e.positionMillis && !isLooping){
                    sound.stopAsync()
                    setIsPlay(false)
                }else{
                    setProgress(e.positionMillis / e.durationMillis)
                    setPositionMillis(e.positionMillis)
                }
            })
        }
    }

    const load = async () => {
        try {
            const { sound } = await Audio.Sound.createAsync(
                { uri: `${DEV.IMAGE_URL}${item.music}` },
                { shouldPlay: false }
            )
            await setSound(sound)
            const result = await sound.getStatusAsync()
            setDurationMillis(result.durationMillis)
            setLoading(true)
        } catch (error) {
            console.log(`error`, error)            
            setLoading(false)
        }
    }

    const msToTime = (duration) => {
        let seconds = Math.floor((duration / 1000) % 60),
            minutes = Math.floor((duration / (1000 * 60)) % 60),
            hours = Math.floor((duration / (1000 * 60 * 60)) % 24)

        hours = (hours < 10) ? "0" + hours : hours
        minutes = (minutes < 10) ? "0" + minutes : minutes
        seconds = (seconds < 10) ? "0" + seconds : seconds
        if(hours=='00'){
            return minutes + ":" + seconds
        }else{
            return hours + ":" + minutes + ":" + seconds
        }
    }

    const likeMusic = async () => {
        const formData = new FormData()
        formData.append('email', user.email)
        formData.append('music_id', item.id)
        if (isLike) {
            const { data } = await Axios().dislikMusic(formData)
            if (data.status === "success") {
                setIsLike(false)
            }
        } else {
            const { data } = await Axios().likeMusic(formData)
            if (data.status === "success") {
                setIsLike(true)
            }
        }
    }

    const setIsLoop = async () => {
        if(!loading){
            return
        }
        if (isLooping) {
            await sound.setIsLoopingAsync(false)
            setIsLooping(false)
        } else {
            await sound.setIsLoopingAsync(true)
            setIsLooping(true)
        }
    }

    const getMusicInfo = async () => {
        const formData = new FormData()
        formData.append('uid', user.id)
        formData.append('mid', item.id)
        const { data } = await Axios().getMusicInfo(formData)
        if (data.status === "success") {
        }
    }

    useEffect(() => {
        getMusicInfo()
        setSound(null)
        load()
        setInterval(() => {
            setTime(new Date())
        }, 1000);
    }, [navigation])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={S.PH20}>
                    <Text style={[S.CLW, S.Tcenter, S.F24, S.FW700, S.MT20, S.MB20]}>Unwiind</Text>
                    <TouchableOpacity style={S.backIcon} onPress={()=>{navigation.goBack(), stopSound()}}>
                        <Icon type="AntDesign" name="down"  style={[S.CLW, S.F24]}/>
                    </TouchableOpacity>
                    <View style={S.Acenter}>
                        <Image source={{uri: `${DEV.IMAGE_URL}${item.thumb}`}} style={S.image}/>
                    </View>
                    <View style={[S.ROW, S.PH35, S.MT10, S.Jbetween, S.Acenter]}>
                        <View>
                            <Text style={[S.CLW, S.F16, S.FW700]}> {item.name} </Text>
                            <Text style={[S.CLW, S.F12, S.FW400]}> {item.description} </Text>
                        </View>
                        <TouchableOpacity onPress={likeMusic}>
                            <Icon type="AntDesign" name={isLike?"heart":"hearto"} style={[S.F24, S.CLW]} />
                        </TouchableOpacity>
                    </View>
                    <View style={[S.Acenter, S.MT20]}>
                        <Progress.Bar 
                            progress={progress} 
                            borderWidth={0} 
                            color={COLOR.blueColor6} 
                            width={LAYOUT.window.width-normalize(100)} 
                            style={{backgroundColor:COLOR.greyColor2}}
                        />
                    </View>
                    <View style={[S.ROW, S.Jbetween, S.PH35, S.MT10]}>
                        <Text style={[S.CLW, S.F14, S.FW400]}> {msToTime(positionMillis)} </Text>
                        <Text style={[S.CLW, S.F14, S.FW400]}> {msToTime(durationMillis)} </Text>
                    </View>
                    <View style={[S.ROW, S.Jbetween, S.MT10, S.PH70]}>
                        <TouchableOpacity>
                            <Icon type="FontAwesome" name="backward" style={[S.F28, S.CLW]}/>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={playSound}>
                            <Icon type="FontAwesome" name={isPlay?"pause":"play"} style={[S.F28, S.CLBule5]}/>
                        </TouchableOpacity>
                        <TouchableOpacity>
                            <Icon type="FontAwesome" name="forward" style={[S.F28, S.CLW]}/>
                        </TouchableOpacity>
                    </View>
                    <View style={[S.ROW, S.Jbetween, S.MT50, S.PH70]}>
                        <TouchableOpacity style={[S.Acenter]}>
                            <Icon type="MaterialIcons" name="access-alarm" style={[S.F24, S.CLW]}/>
                            <Text style={[S.CLW, S.F14, S.FW400]}>{moment(time).format('hh:mm:ss')}</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={setIsLoop}>
                            <Icon type="Entypo" name="retweet" style={[S.F24, isLooping?S.CLW:S.CLGrey1]}/>
                        </TouchableOpacity>
                        <TouchableOpacity>
                            <Icon type="SimpleLineIcons" name="playlist" style={[S.F22, S.CLGrey1]}/>
                        </TouchableOpacity>
                    </View>
                </Content>
                <Footers/>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    image:{
        width:LAYOUT.window.width-normalize(100),
        height:LAYOUT.window.width-normalize(100),
        resizeMode:'contain',
        overflow:'hidden'
    },
    backIcon:{
        position:'absolute',
        top:normalize(20),
        left:normalize(20),
    }
})