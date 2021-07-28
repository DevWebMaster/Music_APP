import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { Audio } from 'expo-av'
import { DEV } from '../constants'
import GuestNavigation from './Guest'
import LoggedNavigation from './Logged'
import { useApi } from '../redux/services'
import { setActiveMusic, setAIndex, setDuration, setIsClose, setIsLike, setIsPlay, setLoading, setProgress, setSound } from '../redux/actions/musicActions'

const Router = () => {
  const dispatch = useDispatch()
  const Api = useApi()
  const { user } = useSelector(state => state.auth)
  const { allMusic, activeMusic, sound, loading, isPlay, isLooping, isClose } = useSelector(state => state.music)

  const loadMusic = async () => {
    dispatch(setSound(null))
    dispatch(setIsPlay(false))
    dispatch(setLoading(false))
    if (sound) {
      await sound.unloadAsync()
    }
    try {
      let index = allMusic.findIndex(e => e.id == activeMusic.id)
      dispatch(setAIndex(index))
      const { sound } = await Audio.Sound.createAsync(
        { uri: `${DEV.IMAGE_URL}${activeMusic.music}` },
        { shouldPlay: false }
      )
      dispatch(setSound(sound))
      const result = await sound.getStatusAsync()
      dispatch(setDuration(result.durationMillis))
      setTimeout(() => {
        dispatch(setLoading(true))
        dispatch(setIsPlay(!isPlay))
      }, 2000)
    } catch (error) {
      dispatch(setLoading(false))
    }
  }

  const stopSound = async () => {
    if (!loading) {
      return
    }
    if (loading) {
      await sound.pauseAsync()
    }
  }

  const musicClose = async () => {
    if (!isClose || !loading) {
      return
    }
    if (sound)
      await sound.stopAsync()
    dispatch(setSound(null))
    dispatch(setIsClose(!isClose))
    dispatch(setActiveMusic(null))
  }

  const playSound = async () => {
    if (!loading) {
      return
    }
    await sound.playAsync()
    sound.setOnPlaybackStatusUpdate((e) => {
      if (e.durationMillis == e.positionMillis && !isLooping) {
        sound.stopAsync()
        dispatch(setIsPlay(false))
      } else {
        // console.log(e)
        dispatch(setProgress(e.positionMillis / e.durationMillis, e.positionMillis))
      }
    })
  }

  const getMusicInfo = async () => {
    const formData = new FormData()
    formData.append('uid', user.id)
    formData.append('mid', activeMusic.id)
    const { data } = await Api.getMusicInfo(formData)
    if (data.status === "success") {
    }
  }

  useEffect(() => {
    Audio.setAudioModeAsync({
      playsInSilentModeIOS: false,
      allowsRecordingIOS: false,
      interruptionModeIOS: Audio.INTERRUPTION_MODE_IOS_DO_NOT_MIX,
      interruptionModeAndroid: Audio.INTERRUPTION_MODE_ANDROID_DO_NOT_MIX,
      shouldDuckAndroid: false,
      playThroughEarpieceAndroid: false
    })
  }, [])

  useEffect(() => {
    loadMusic()
    dispatch(setIsLike(activeMusic?.is_liked === '1'))
  }, [activeMusic])

  useEffect(() => {
    if (isPlay) {
      playSound()
      getMusicInfo()
    } else if (!isPlay) {
      stopSound()
    }
  }, [isPlay])

  useEffect(() => {
    musicClose()
  }, [isClose])

  if (user) {
    return <LoggedNavigation />
  } else {
    return <GuestNavigation />
  }
}

export default Router
