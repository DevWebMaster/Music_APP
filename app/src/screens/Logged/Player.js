import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { ActivityIndicator, StyleSheet, View, Text, Image, TouchableOpacity, BackHandler } from 'react-native'
import { Container, Content, Icon } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import moment from 'moment'
import * as Progress from 'react-native-progress'
import { COLOR, DEV, Images, LAYOUT, Styles } from '../../constants'
import { useApi } from '../../redux/services'
import { msToTime, setActiveMusic, setIsLike, setIsLooping, setIsPlay } from '../../redux/actions/musicActions'

export default ({ navigation }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector(state => state.auth)
    const { progress, positionMillis, durationMillis, loading, aIndex, isLooping, isPlay, isLike, sound, activeMusic, allMusic } = useSelector(state => state.music)
    const [time, setTime] = useState(new Date())
    let timer = null

    const likeMusic = async () => {
        const formData = new FormData()
        formData.append('email', user.email)
        formData.append('music_id', activeMusic.id)
        if (isLike) {
            const { data } = await Api.dislikMusic(formData)
            if (data.status === "success") {
                dispatch(setIsLike(false))
            }
        } else {
            const { data } = await Api.likeMusic(formData)
            if (data.status === "success") {
                dispatch(setIsLike(true))
            }
        }
    }

    const setIsLoop = async () => {
        if (!loading) {
            return
        }
        if (isLooping) {
            await sound.setIsLoopingAsync(false)
            dispatch(setIsLooping(false))
        } else {
            await sound.setIsLoopingAsync(true)
            dispatch(setIsLooping(true))
        }
    }

    const musicPlay = async () => {
        dispatch(setIsPlay(!isPlay))
    }

    const nextMusic = async () => {
        let index = allMusic.findIndex(e => e.id == activeMusic.id)
        if (index + 1 <= allMusic.length) {
            if (loading && isPlay) {
                await sound.stopAsync()
            }
            dispatch(setActiveMusic(allMusic[index + 1]))
        }
    }

    const prevMusic = async () => {
        let index = allMusic.findIndex(e => e.id == activeMusic.id)
        if (index > 0) {
            if (loading && isPlay) {
                await sound.stopAsync()
            }
            dispatch(setActiveMusic(allMusic[index - 1]))
        }
    }

    const clear = () => {
        clearTimeout(timer)
    }

    const settime = () => {
        timer = setInterval(() => {
            setTime(new Date())
        }, 1000)
    }

    useEffect(() => {
        const backHandler = BackHandler.addEventListener('hardwareBackPress', clear)
        navigation.addListener('didBlur', clear)
        navigation.addListener('didFocus', settime)
        return () => {
            backHandler.remove()
        }
    }, [navigation])

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content showsVerticalScrollIndicator={false}>
                    <View style={[S.ROW, S.Acenter, S.MV20, S.Jbetween, S.PH20]}>
                        <TouchableOpacity onPress={() => navigation.goBack()}>
                            <Icon type="AntDesign" name="down" style={[S.CLW, S.F24]} />
                        </TouchableOpacity>
                        <Image source={Images.Logos} style={S.image} />
                        <View style={{ width: normalize(24) }} />
                    </View>
                    <View style={{ paddingHorizontal: normalize(60) }}>
                        <View style={S.Acenter}>
                            <Image source={{ uri: `${DEV.IMAGE_URL}${activeMusic?.thumb}` }} style={S.images} />
                        </View>
                        <View style={[S.ROW, S.MT30, S.Jbetween, S.Acenter]}>
                            <View style={{ maxWidth: '90%' }}>
                                <Text style={[S.F18, S.FW700, S.FRoboto, { color: '#d4d4d4' }]}>{activeMusic?.name}</Text>
                                <Text style={[S.F14, S.FW400, S.FRoboto, { color: '#a5a5a6' }]}>{activeMusic?.description}</Text>
                            </View>
                            <TouchableOpacity onPress={likeMusic}>
                                <Icon type="AntDesign" name={isLike ? "heart" : "hearto"} style={[S.F24, { color: '#dadada' }]} />
                            </TouchableOpacity>
                        </View>
                        <View style={[S.Acenter, S.MT30]}>
                            <Progress.Bar
                                progress={progress}
                                borderWidth={0}
                                color={COLOR.blueColor6}
                                width={LAYOUT.window.width - normalize(120)}
                                style={{ backgroundColor: COLOR.greyColor2 }}
                            />
                        </View>
                        <View style={[S.ROW, S.Jbetween, S.MT10]}>
                            <Text style={[S.F14, S.FW400, S.CText5, S.FRoboto]}> {msToTime(positionMillis)} </Text>
                            <Text style={[S.F14, S.FW400, S.CText5, S.FRoboto]}> {msToTime(durationMillis)} </Text>
                        </View>
                        <View style={[S.ROW, S.Jbetween, S.MT30, S.PH30, S.Acenter]}>
                            <TouchableOpacity onPress={prevMusic} disabled={aIndex == 0}>
                                <Icon type="FontAwesome" name="backward" style={[S.F28, aIndex == 0 ? S.CLGrey1 : S.CText5]} />
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => musicPlay()} disabled={!loading}>
                                {
                                    loading ?
                                        <Icon type="FontAwesome" name={isPlay ? "pause" : "play"} style={[S.F28, S.CLBule5]} /> :
                                        <ActivityIndicator animating={true} size="small" color={COLOR.greenColor} />
                                }
                            </TouchableOpacity>
                            <TouchableOpacity onPress={nextMusic} disabled={(aIndex + 1) == allMusic.length}>
                                <Icon type="FontAwesome" name="forward" style={[S.F28, ((aIndex + 1) == allMusic.length ? S.CLGrey1 : S.CText5)]} />
                            </TouchableOpacity>
                        </View>
                    </View>
                    <View style={[S.ROW, S.Jbetween, S.MT30, S.PH55]}>
                        <View style={{ width: '33%', alignItems: 'center' }}>
                            <TouchableOpacity style={[S.Acenter]}>
                                <Icon type="MaterialIcons" name="access-alarm" style={[S.F24, S.CLW]} />
                                <Text style={[S.CLW, S.F14, S.FW400, S.FRoboto]}>{moment(time).format('hh:mm:ss')}</Text>
                            </TouchableOpacity>
                        </View>
                        <View style={{ width: '33%', alignItems: 'center' }}>
                            <TouchableOpacity onPress={setIsLoop}>
                                <Icon type="Entypo" name="retweet" style={[S.F24, isLooping ? S.CLW : S.CLGrey1]} />
                            </TouchableOpacity>
                        </View>
                        <View style={{ width: '33%', alignItems: 'center' }}>
                            <TouchableOpacity>
                                <Icon type="SimpleLineIcons" name="playlist" style={[S.F22, S.CLGrey1]} />
                            </TouchableOpacity>
                        </View>
                    </View>
                </Content>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    images: {
        width: LAYOUT.window.width - normalize(120),
        height: LAYOUT.window.width - normalize(120),
        borderRadius: normalize(20),
        overflow: 'hidden'
    },
})