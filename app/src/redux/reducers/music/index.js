import produce from 'immer'

const initialState = {
  progress: 0,
  positionMillis: 0,
  durationMillis: 0,
  loading: false,
  aIndex: 0,
  isLooping: false,
  isPlay: false,
  isLike: false,
  isClose: false,
  sound: null,
  activeMusic: null,
  allMusic: [],
}

export default function reducer(state = initialState, action) {
  return produce(state, (draft) => {
    switch (action.type) {
      case 'SET_ALL_MUSIC':
        draft.allMusic = action.payload.allMusic
        return
      case 'SET_ACTIVE_MUSIC':
        draft.activeMusic = action.payload.activeMusic
        return
      case 'SET_SOUND':
        draft.sound = action.payload.sound
        return
      case 'SET_IS_PLAY':
        draft.isPlay = action.payload.isPlay
        return
      case 'SET_IS_LIKE':
        draft.isLike = action.payload.isLike
        return
      case 'SET_IS_LOOPING':
        draft.isLooping = action.payload.isLooping
        return
      case 'SET_IS_CLOSE':
        draft.isClose = action.payload.isClose
        return
      case 'SET_A_INDEX':
        draft.aIndex = action.payload.aIndex
        return
      case 'SET_LOADING':
        draft.loading = action.payload.loading
        return
      case 'SET_DURATION':
        draft.durationMillis = action.payload.durationMillis
        return
      case 'SET_PROGRESS':
        draft.progress = action.payload.progress
        draft.positionMillis = action.payload.positionMillis
        return
      default:
        return state
    }
  })
}
