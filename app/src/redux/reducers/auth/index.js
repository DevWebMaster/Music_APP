import produce from 'immer'

const initialState = {
  isWelcome: false,
  user: null,
  email: null,
  token: null,
}

export default function reducer(state = initialState, action) {
  return produce(state, (draft) => {
    switch (action.type) {
      case 'WELCOME_DONE':
        draft.isWelcome = true
        return
      case 'SET_USERINFO':
        draft.user = action.payload.user
        return
      case 'LOG_OUT':
        draft.user = null
        return
      case 'SET_TOKEN':
        draft.token = action.payload.token
        return
      case 'SET_MAIL':
        draft.email = action.payload.email
        return
      default:
        return state
    }
  })
}
