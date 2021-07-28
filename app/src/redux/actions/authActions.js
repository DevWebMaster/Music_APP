export const welcomeDone = () => {
  return { type: 'WELCOME_DONE' }
}

export const setUserInfo = (user) => {
  return {
    type: 'SET_USERINFO',
    payload: { user },
  }
}

export const Logut = () => {
  return { type: 'LOG_OUT' }
}

export const setToken = (token) => {
  return {
    type: 'SET_TOKEN',
    payload: { token },
  }
}

export const setMail = (email) => {
  return {
    type: 'SET_MAIL',
    payload: { email },
  }
}