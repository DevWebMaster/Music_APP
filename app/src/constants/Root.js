const ApiList = {
  login: 'login',
  register: 'register',
  getCategory: 'getgenreslist',
  getArtist: 'getdjslist',
  getProfile: 'getprofile',
  setProfile: 'setprofile',
  getMusicList: 'getmusiclist',
  getTopMusicList: 'gettopmusiclist',
  getMusicsWithGenre: 'getmusicswithgenre',
  getMusicsWithArtist: 'getmusicswithdj',
  getMusicInfo: 'getmusicinfo',
  sendNotification: 'sendnotification',
  likeMusic: 'like-music',
  dislikMusic: 'dislike-music',
  addPlayList: 'addplaylist',
  removePlayList: 'removeplaylist',
  getPlayList: 'getplaylist',
  addComment: 'add-comment',
  updateComment: 'update-comment',
  deleteComment: 'delete-comment',
  setProfileInfo: 'setprofileinfo',
  setProfilePassword: 'setprofilepassword',
  getRecentList: 'getrecentlist',
  getRecommendList: 'getrecommendmusicswithgenre',
  getLibraryList: 'getlibrarylist',
}

const dev = {
  BACKEND_URL: "http://192.168.104.31/music_backend/index.php/",
  IMAGE_URL: "http://192.168.104.31/music_backend/",
  player: "players",
  ...ApiList
}

const production = {
  BACKEND_URL: "http://3.65.175.78/index.php/",
  IMAGE_URL: "http://3.65.175.78/",
  player: "players",
  ...ApiList
}

export const DEV = production