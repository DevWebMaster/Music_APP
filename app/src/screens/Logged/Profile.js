import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { StyleSheet, View, Text, TouchableOpacity } from 'react-native'
import { Container, Content, Icon, Input, Item, Label } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import normalize from 'react-native-normalize'
import * as ImagePicker from 'expo-image-picker'
import ToggleSwitch from 'toggle-switch-react-native'
import { COLOR, Images, Styles } from '../../constants'
import { PlayerPreview, UserAvatars } from '../../components'
import { Logut, setUserInfo } from '../../redux/actions/authActions'
import { useApi } from '../../redux/services'

const initUserInfo = {
    email: '',
    username: '',
    password: '',
    enabledmail: false,
    image: Images.Profile,
}

export default () => {
    const dispatch = useDispatch()
    const Api = useApi()
    const { user } = useSelector((state) => state.auth)
    const [userInfo, setUserInfos] = useState(initUserInfo)
    const [password, setPassword] = useState('')

    const logout = () => {
        dispatch(Logut())
    }

    const getProfile = async () => {
        const formData = new FormData()
        formData.append('email', user.email)
        const { data } = await Api.getProfile(formData)
        if (data.status === 'success') {
            setUserInfos({ ...userInfo, ...data.data[0] })
            setUserInfo({ ...userInfo, ...data.data[0] })
        }
    }

    const pickImage = async () => {
        try {
            const result = await ImagePicker.launchImageLibraryAsync({
                mediaTypes: ImagePicker.MediaTypeOptions.All,
                base64: true,
                allowsEditing: true,
                aspect: [1, 1],
            })
            if (!result.cancelled) {
                const formData = new FormData()
                formData.append('email', user.email)
                formData.append('isDjs', userInfo.isDjs)
                formData.append(
                    'base64string',
                    `data:image/jpgbase64,${result.base64}`
                )
                const { data } = await Api.setProfile(formData)
                if (data.status === 'success') {
                    setUserInfos({
                        ...userInfo,
                        profile_avatar: data.userInfo[0].profile_avatar,
                    })
                    setUserInfo({
                        ...userInfo,
                        profile_avatar: data.userInfo[0].profile_avatar,
                    })
                }
            }
        } catch (err) {
            console.log(err)
        }
    }

    const setProfileInfo = async () => {
        const formData = new FormData()
        formData.append('email', user.email)
        formData.append('username', userInfo.username)
        formData.append('enabledmail', userInfo.enabledmail)
        const { data } = await Api.setProfileInfo(formData)
        if (data.status === 'success') {
            console.log(`data`, data)
        }
    }

    const setProfilePassword = async (e) => {
        const formData = new FormData()
        formData.append('email', user.email)
        formData.append('password', e)
        const { data } = await Api.setProfilePassword(formData)
        if (data.status === 'success') {
            console.log(`data`, data)
        }
    }

    const changeUserInfo = async (field, e) => {
        await setUserInfos({ ...userInfo, [field]: e })
        setProfileInfo()
    }

    const changePassword = async (e) => {
        setPassword(e)
        setProfilePassword(e)
    }

    useEffect(() => {
        getProfile()
    }, [])

    return (
        <Container>
            <LinearGradient
                colors={COLOR.linearGradientColor}
                style={S.linearGradient}
            >
                <Content contentContainerStyle={[S.PH20, S.PB75]} showsVerticalScrollIndicator={false}>
                    <View style={[S.MT25]}>
                        <View style={[S.ROW, S.Jbetween, S.W100P]}>
                            <TouchableOpacity style={S.Astart} onPress={logout}>
                                <Icon type="SimpleLineIcons" name="logout" style={[S.CLW, S.F24]} />
                            </TouchableOpacity>
                            <Text style={[S.CLW, S.F16, S.FW700, S.Jcenter, S.FRoboto]}>Edit Profile</Text>
                            <View style={{ width: normalize(24) }} />
                        </View>
                        <View style={[S.Acenter]}>
                            <View>
                                <View style={[S.Acenter, S.MT20, S.imageCover]}>
                                    <UserAvatars
                                        user={{
                                            avatar: userInfo?.profile_avatar,
                                            email: userInfo.email,
                                        }}
                                        size={120}
                                    />
                                </View>
                                <TouchableOpacity style={[S.plusIcon]} onPress={pickImage}>
                                    <Icon
                                        type="AntDesign"
                                        name="pluscircle"
                                        style={[S.CLBule6, S.F30]}
                                    />
                                </TouchableOpacity>
                            </View>
                        </View>
                        <Item stackedLabel style={[S.inputCover, S.MT10]}>
                            <Label style={S.label}>USER NAME</Label>
                            <Input
                                style={[S.CLW, S.FRoboto]}
                                autoCapitalize={'none'}
                                keyboardType="default"
                                value={userInfo.username}
                                onChangeText={(e) => changeUserInfo('username', e)}
                            />
                        </Item>
                        <Item stackedLabel style={[S.inputCover, S.MT10]}>
                            <Label style={S.label}>EMAIL</Label>
                            <Input
                                style={[S.CLW, S.FRoboto]}
                                autoCapitalize={'none'}
                                keyboardType="email-address"
                                value={userInfo.email}
                                disabled
                            />
                        </Item>
                        <Item stackedLabel style={[S.inputCover, S.MT10]}>
                            <Label style={S.label}>PASSWORD</Label>
                            <Input
                                style={[S.CLW, S.FRoboto]}
                                secureTextEntry={true}
                                autoCapitalize={'none'}
                                value={password}
                                onChangeText={(e) => changePassword(e)}
                            />
                        </Item>
                        <View style={[S.W100P, S.MT20]}>
                            <Text style={[S.label]}>NOTIFICATIONS</Text>
                            <View style={[S.ROW, S.Jbetween]}>
                                <Text style={[S.CLW, S.F18, S.FRoboto]}>Email notification</Text>
                                <ToggleSwitch
                                    isOn={userInfo.enabledmail == '1'}
                                    size="medium"
                                    onColor={COLOR.blueColor6}
                                    offColor={COLOR.inputLabelColor}
                                    onToggle={(e) => changeUserInfo('enabledmail', e ? '1' : '0')}
                                />
                            </View>
                        </View>
                    </View>
                </Content>
                <PlayerPreview />
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
    imageCover: {
        borderWidth: normalize(5),
        borderColor: COLOR.whiteColor,
        borderRadius: normalize(100),
        height: normalize(120),
        width: normalize(120),
        overflow: 'hidden',
        alignItems: 'center',
        justifyContent: 'center',
    },
    plusIcon: {
        position: 'absolute',
        right: normalize(5),
        bottom: normalize(5),
        borderRadius: normalize(30),
        backgroundColor: COLOR.whiteColor,
    },
})
