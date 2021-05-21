import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { StyleSheet, View, Text, Image, TouchableOpacity } from 'react-native'
import { Container, Content, Icon, Input, Item, Label } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import * as ImagePicker from 'expo-image-picker'
import ToggleSwitch from 'toggle-switch-react-native'
import { COLOR, DEV, Images, Styles } from '../../constants'
import { Footers } from '../../components'
import { Logut, setUserInfo } from '../../redux/actions/authActions'
import { Axios } from '../../redux/services'

const initUserInfo = {
    email: '',
    username: '',
    password: '',
    notification:false,
    appUpdate:false,
    image:Images.Profile
}

export default () =>{
    const dispatch = useDispatch()
    const { user } = useSelector(state => state.auth)
    const [userInfo, setUserInfos] = useState(initUserInfo)
    const logout = () => {
        dispatch(Logut())
    }

    const getProfile = async () => {
        const formData = new FormData()
        formData.append('email', user.email)
        const { data } = await Axios().getProfile(formData)
        if (data.status === "success") {
            setUserInfos({...userInfo, ...data.data[0]})
            setUserInfo({...userInfo, ...data.data[0]})
        }
    }

    const pickImage = async () => {
        try {
          const result = await ImagePicker.launchImageLibraryAsync({
            mediaTypes: ImagePicker.MediaTypeOptions.All,
            base64: true,
            allowsEditing: true,
            aspect: [1, 1]
          })
          if (!result.cancelled) {
            const formData = new FormData()
            formData.append('email', user.email)
            formData.append('username', userInfo.username)
            formData.append('isDjs', userInfo.isDjs)
            formData.append('base64string', `data:image/jpg;base64,${result.base64}`)
            const { data } = await Axios().setProfile(formData)
            if (data.status === "success") {
                setUserInfos({...userInfo, profile_avatar: data.userInfo[0].profile_avatar})
                setUserInfo({...userInfo, profile_avatar: data.userInfo[0].profile_avatar})
            }
          }
        } catch (err) {
          console.log(err)
        }
      }

    useEffect(() => {
        getProfile()
    }, [])
    
    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient}>
                <Content contentContainerStyle={S.PH20}>
                    <TouchableOpacity style={S.backIcon} onPress={logout}>
                        <Icon type="SimpleLineIcons" name="logout"  style={[S.CLW, S.F24]}/>
                    </TouchableOpacity>
                    <View style={[S.Acenter, S.MT25]}>
                        <Text style={[S.CLW, S.F16, S.FW700]}>Edit Profile</Text>
                        <View>
                            <View style={[S.Acenter, S.MT20, S.imageCover]}>
                                {
                                    userInfo.profile_avatar ? 
                                    <Image source={{uri:`${DEV.IMAGE_URL}${userInfo.profile_avatar}`}} style={S.image}/>:
                                    <Image source={Images.Profile} style={S.image}/>
                                }
                            </View>
                            <TouchableOpacity style={[S.plusIcon]} onPress={pickImage}>
                                <Icon type="AntDesign" name="pluscircle" style={[S.CLBule6, S.F30]}/>
                            </TouchableOpacity>
                        </View>
                        <Item floatingLabel style={[S.inputCover, S.MT10]} >
                            <Label style={S.label}>USER NAME</Label>
                            <Input
                                style={[S.CLW]}
                                autoCapitalize={'none'}
                                keyboardType='default'
                                value={userInfo.username}
                                onChangeText={(e)=>setUserInfos({...userInfo, username:e})}
                            />
                        </Item>
                        <Item floatingLabel style={[S.inputCover, S.MT10]} >
                            <Label style={S.label}>EMAIL</Label>
                            <Input
                                style={[S.CLW]}
                                autoCapitalize={'none'}
                                keyboardType='email-address'
                                value={userInfo.email}
                                onChangeText={(e)=>setUserInfos({...userInfo, email:e})}
                            />
                        </Item>
                        <Item floatingLabel style={[S.inputCover, S.MT10]}>
                            <Label style={S.label}>PASSWORD</Label>
                            <Input
                                style={[S.CLW]}
                                secureTextEntry={true}
                                autoCapitalize={'none'}
                                value={'password'}
                                onChangeText={(e)=>setUserInfos({...userInfo, password:e})}
                            />
                        </Item>
                        <View style={[S.W100P, S.MT20]}>
                            <Text style={[S.label]}>NOTIFICATIONS</Text>
                            <View style={[S.ROW, S.Jbetween]}>
                                <Text style={[S.CLW, S.F18]}>Email notification</Text>
                                <ToggleSwitch
                                    isOn={userInfo.notification}
                                    size="medium"
                                    onColor={COLOR.inputLabelColor}
                                    offColor={COLOR.blueColor6}
                                    onToggle={e => setUserInfos({...userInfo, notification:e})}
                                />
                            </View>
                        </View>
                        <View style={[S.W100P, S.MT20]}>
                            <Text style={[S.label]}>UPDATE</Text>
                            <View style={[S.ROW, S.Jbetween]}>
                                <Text style={[S.CLW, S.F18]}>App Update</Text>
                                <ToggleSwitch
                                    isOn={userInfo.appUpdate}
                                    size="medium"
                                    onColor={COLOR.inputLabelColor}
                                    offColor={COLOR.blueColor6}
                                    onToggle={e => setUserInfos({...userInfo, appUpdate:e})}
                                />
                            </View>
                        </View>
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
        width:normalize(120),
        height:normalize(120),
    },
    imageCover:{
        borderWidth:normalize(5),
        borderColor:COLOR.whiteColor,
        borderRadius:normalize(100),
        height:normalize(120),
        width:normalize(120),
        overflow:'hidden',
        alignItems:'center',
        justifyContent:'center',
    },
    backIcon:{
        position:'absolute',
        top:normalize(20),
        left:normalize(20),
    },
    logoutIcon:{
        position:'absolute',
        top:normalize(20),
        right:normalize(20),
    },
    plusIcon:{
        position:'absolute',
        right:normalize(5),
        bottom:normalize(5),
        borderRadius:normalize(30),
        backgroundColor:COLOR.whiteColor
    }
})