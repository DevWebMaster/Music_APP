import firebase from 'firebase/app'
import 'firebase/auth'
import 'firebase/firestore'
import 'firebase/storage'
import 'firebase/database'
const firebaseConfig = {
  apiKey: 'AIzaSyAvEjJt7KFJuSN0Ijy1dNQERD2oQ-z68bQ',
  authDomain: 'unwiind-b1065.firebaseapp.com',
  databaseURL: 'https://unwiind-b1065-default-rtdb.firebaseio.com',
  projectId: 'unwiind-b1065',
  storageBucket: 'unwiind-b1065.appspot.com',
  messagingSenderId: '274299446199',
  appId: '1:274299446199:android:b3fe27d7b3d29144053e32',
}
if (!firebase.apps.length) {
  firebase.initializeApp(firebaseConfig)
}
const Firestore = firebase.firestore()
const Storage = firebase.storage()
const FieldValue = firebase.firestore.FieldValue
const Database = firebase.database()
export { firebase, Firestore, Storage, FieldValue, Database }