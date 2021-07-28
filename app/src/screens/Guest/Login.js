import React, { useState } from 'react'
import { StyleSheet, View, Text, Image, TouchableOpacity } from 'react-native'
import { Container, Content, Icon, Input, Item, Label, Toast } from 'native-base'
import * as GoogleSignIn from 'expo-google-sign-in'
import { LinearGradient } from 'expo-linear-gradient'
import { COLOR, Images, Styles } from '../../constants'
import { setUserInfo } from "../../redux/actions/authActions"
import { Loading } from '../../components'
import { useApi } from '../../redux/services'
import { useDispatch } from 'react-redux'

export default ({ navigation }) => {
    const dispatch = useDispatch()
    const Api = useApi()
    const [loading, setLoading] = useState(false)
    const [loginInfo, setLoginInfo] = useState({
        email: '',
        password: ''
    })

    const handleLogin = async () => {
        if (loginInfo.email == "") {
            Toast.show({ text: "Email is required!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' })
        } else if (loginInfo.password == "") {
            Toast.show({ text: "Password is required!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' })
        } else {
            setLoading(true)
            const formData = new FormData()
            formData.append('email', loginInfo.email)
            formData.append('password', loginInfo.password)
            const { data } = await Api.login(formData)
            if (data.status === 'failed') {
                Toast.show({ text: data.msg, buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' })
            } else {
                const result = await Api.getProfile(formData)
                if (result.data.status === "success") {
                    dispatch(setUserInfo({ ...data.userInfo, ...result.data.data[0] }))
                } else {
                    dispatch(setUserInfo(data.userInfo))
                }
            }
            setLoading(false)
        }
    }

    const _syncUserWithStateAsync = async () => {
        const user = await GoogleSignIn.signInSilentlyAsync()
        setLoading(true)
        const formData = new FormData()
        formData.append('email', user.email)
        formData.append('token', user.auth.idToken)
        const { data } = await Api.login(formData)
        const result = await Api.getProfile(formData)
        if (result.data.status === "success") {
            dispatch(setUserInfo({ ...data.userInfo, ...result.data.data[0] }))
        } else {
            dispatch(setUserInfo(data.userInfo))
        }
        setLoading(false)
    }

    // const initAsync = async () => {
    //     await GoogleSignIn.initAsync({ clientId: '274299446199-ma6majcins68frkdm3ler73rp3n4t3r9.apps.googleusercontent.com' })
    //     _syncUserWithStateAsync()
    // }

    const signInAsync = async () => {
        try {
            await GoogleSignIn.askForPlayServicesAsync()
            const { type, user } = await GoogleSignIn.signInAsync()
            if (type === 'success') {
                _syncUserWithStateAsync()
            }
        } catch ({ message }) {
            alert('login: Error:' + message)
        }
    }

    if (loading) {
        return (<Loading />)
    }

    return (
        <Container>
            <LinearGradient colors={COLOR.linearGradientColor} style={S.linearGradient1}>
                <Content contentContainerStyle={S.PH20}>
                    <View style={[S.Acenter, S.MB30, S.MT50]}>
                        <Image source={Images.Logos} style={S.image} />
                    </View>
                    <Text style={[S.CLW, S.F25, S.FW700, S.MT30, S.FRoboto]}>Login</Text>
                    <Text style={[S.CLW, S.F16, S.FW400, S.MT5, S.FRoboto]}>Please sign in to continue.</Text>
                    <Item floatingLabel style={S.inputCover} >
                        <Icon type="FontAwesome" name="envelope-o" style={S.inputIcon} />
                        <Label style={S.label}>EMAIL</Label>
                        <Input
                            style={[S.CLW, S.FW400, S.FRoboto]}
                            autoCapitalize={'none'}
                            keyboardType='email-address'
                            value={loginInfo.email}
                            onChangeText={(e) => setLoginInfo({ ...loginInfo, email: e })}
                        />
                    </Item>
                    <Item floatingLabel style={S.inputCover}>
                        <Icon type="MaterialCommunityIcons" name="lock" style={S.inputIcon} />
                        <Label style={S.label}>PASSWORD</Label>
                        <Input
                            style={[S.CLW, S.FW400, S.FRoboto]}
                            secureTextEntry={true}
                            autoCapitalize={'none'}
                            value={loginInfo.password}
                            onChangeText={(e) => setLoginInfo({ ...loginInfo, password: e })}
                        />
                    </Item>
                    <View style={[S.Aend, S.MT20]}>
                        <TouchableOpacity onPress={handleLogin}>
                            <LinearGradient
                                start={[1, 0]}
                                end={[0, 1]}
                                colors={COLOR.buttonGColor}
                                style={S.authButton}>
                                <Text style={[S.authButtonText, S.FRoboto]}>LOGIN</Text>
                                <Icon type="AntDesign" name="arrowright" style={S.rightIcon} />
                            </LinearGradient>
                        </TouchableOpacity>
                    </View>
                    <View style={S.MT50}>
                        <Text style={[S.orText, S.FRoboto]}>Or Sign in with</Text>
                    </View>
                    <View style={[S.MT20, S.ROW, S.Jcenter]}>
                        <TouchableOpacity style={S.signWithButton}>
                            <Image source={Images.Google} style={S.OsignIcon} />
                        </TouchableOpacity>
                        <TouchableOpacity style={S.signWithButton}>
                            <Image source={Images.Facebook} style={S.OsignIcon} />
                        </TouchableOpacity>
                        <TouchableOpacity style={S.signWithButton}>
                            <Image source={Images.Twitter} style={S.OsignIcon} />
                        </TouchableOpacity>
                    </View>
                    <View style={[S.MT50, S.ROW, S.Jcenter]}>
                        <Text style={[S.orText, S.FRoboto]}>Dont't have an account?   </Text>
                        <TouchableOpacity onPress={() => navigation.push('CreateAccountScreen')}>
                            <Text style={[S.orText, S.FRoboto, S.FW700, S.CText7]}>Sign up</Text>
                        </TouchableOpacity>
                    </View>
                </Content>
            </LinearGradient>
        </Container>
    )
}

const S = StyleSheet.create({
    ...Styles,
})