export const setAllMusic = (allMusic) => {
  return {
    type: 'SET_ALL_MUSIC',
    payload: { allMusic },
  }
}

export const setActiveMusic = (activeMusic) => {
  return {
    type: 'SET_ACTIVE_MUSIC',
    payload: { activeMusic },
  }
}

export const setSound = (sound) => {
  return {
    type: 'SET_SOUND',
    payload: { sound },
  }
}

export const setIsPlay = (isPlay) => {
  return {
    type: 'SET_IS_PLAY',
    payload: { isPlay },
  }
}

export const setIsLike = (isLike) => {
  return {
    type: 'SET_IS_LIKE',
    payload: { isLike },
  }
}

export const setIsLooping = (isLooping) => {
  return {
    type: 'SET_IS_LOOPING',
    payload: { isLooping },
  }
}

export const setIsClose = (isClose) => {
  return {
    type: 'SET_IS_CLOSE',
    payload: { isClose },
  }
}

export const setAIndex = (aIndex) => {
  return {
    type: 'SET_A_INDEX',
    payload: { aIndex },
  }
}

export const setLoading = (loading) => {
  return {
    type: 'SET_LOADING',
    payload: { loading },
  }
}

export const setDuration = (durationMillis) => {
  return {
    type: 'SET_DURATION',
    payload: { durationMillis },
  }
}

export const setProgress = (progress, positionMillis) => {
  return {
    type: 'SET_PROGRESS',
    payload: { progress, positionMillis },
  }
}

export const msToTime = (duration) => {
  let seconds = Math.floor((duration / 1000) % 60),
    minutes = Math.floor((duration / (1000 * 60)) % 60),
    hours = Math.floor((duration / (1000 * 60 * 60)) % 24)

  hours = (hours < 10) ? "0" + hours : hours
  minutes = (minutes < 10) ? "0" + minutes : minutes
  seconds = (seconds < 10) ? "0" + seconds : seconds
  if (hours == '00') {
    return minutes + ":" + seconds
  } else {
    return hours + ":" + minutes + ":" + seconds
  }
}