import axios from "axios"
import { DEV } from "../../constants"


class AxiosService {
  constructor() {
    axios.interceptors.request.use(
      config => {
        config.baseURL = DEV.BACKEND_URL
        config.headers['Content-Type'] = 'multipart/form-data'
        config.headers.Accept = 'multipart/form-data'
        return config
      },
      error => Promise.reject(error)
    )
    axios.interceptors.response.use(
      response => response,
      error => {
        return Promise.reject(error)
      }
    )
    axios.interceptors.response.use(
      response => response,
      error => {
        const { response } = error
        if (response && response.status === 500) {
          // console.log('response', response)
        }
        return Promise.reject(error)
      }
    )
  }

  login(...args) {
    return axios.post(DEV.login, ...args)
  }

  register(...args) {
    return axios.post(DEV.register, ...args)
  }

  getCategory(...args) {
    return axios.post(DEV.getCategory, ...args)
  }

  getTopMusicList(...args) {
    return axios.post(DEV.getTopMusicList, ...args)
  }

  getMusicsWithGenre(...args) {
    return axios.post(DEV.getMusicsWithGenre, ...args)
  }

  getMusicsWithArtist(...args) {
    return axios.post(DEV.getMusicsWithArtist, ...args)
  }

  getProfile(...args) {
    return axios.post(DEV.getProfile, ...args)
  }

  getArtist(...args) {
    return axios.post(DEV.getArtist, ...args)
  }

  likeMusic(...args) {
    return axios.post(DEV.likeMusic, ...args)
  }

  dislikMusic(...args) {
    return axios.post(DEV.dislikMusic, ...args)
  }

  setProfile(...args) {
    return axios.post(DEV.setProfile, ...args)
  }

  setProfileInfo(...args) {
    return axios.post(DEV.setProfileInfo, ...args)
  }

  setProfilePassword(...args) {
    return axios.post(DEV.setProfilePassword, ...args)
  }

  getMusicInfo(...args) {
    return axios.post(DEV.getMusicInfo, ...args)
  }

  getRecentList(...args) {
    return axios.post(DEV.getRecentList, ...args)
  }

  getRecommendList(...args) {
    return axios.post(DEV.getRecommendList, ...args)
  }

  getLibraryList(...args) {
    return axios.post(DEV.getLibraryList, ...args)
  }
}

export const useApi = () => {
  return new AxiosService()
}

