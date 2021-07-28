import React, { useState } from 'react'
import { StyleSheet, View, Text, Image, TouchableOpacity } from 'react-native'
import { Container, Content, Icon, Input, Item, Label, Toast } from 'native-base'
import { LinearGradient } from 'expo-linear-gradient'
import { COLOR, Images, Styles } from '../../constants'
import { Loading } from '../../components'
import { useApi } from '../../redux/services'

export default ({ navigation }) => {
    const [loading, setLoading] = useState(false)
    const Api = useApi()
    const [userInfo, setUserInfo] = useState({
        username: '',
        email: '',
        password: '',
        cpassword: '',
    })

    const handleRegister = async () => {
        if (userInfo.email == "") {
            Toast.show({ text: "Email is required!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' });
        } else if (userInfo.password == "") {
            Toast.show({ text: "Password is required!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' });
        } else if (userInfo.cpassword == "") {
            Toast.show({ text: "Confirm Password is required!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' });
        } else if (userInfo.cpassword !== userInfo.password) {
            Toast.show({ text: "Confirm Password is not match!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' });
        } else if (userInfo.username == "") {
            Toast.show({ text: "UserName is required!", buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' });
        } else {
            setLoading(true)
            const formData = new FormData()
            formData.append('email', userInfo.email)
            formData.append('username', userInfo.username)
            formData.append('password', userInfo.password)
            const { data } = await Api.register(formData)
            if (data.status === 'failed') {
                Toast.show({ text: data.msg, buttonText: "Okay", type: "danger", duration: 4000, position: 'bottom' })
            } else {
                Toast.show({ text: data.msg, buttonText: "Okay", type: "success", duration: 4000, position: 'bottom' })
                navigation.navigate('LoginScreen')
            }
            setLoading(false)
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
                    <Text style={[S.CLW, S.F25, S.FW700, S.MT10, S.FRoboto]}>Create Account</Text>
                    <Item floatingLabel style={S.inputCover} >
                        <Icon type="Feather" name="user" style={S.inputIcon} />
                        <Label style={S.label}>USERNAME</Label>
                        <Input
                            style={[S.CLW, S.FW400, S.FRoboto]}
                            autoCapitalize={'none'}
                            value={userInfo.username}
                            onChangeText={(e) => setUserInfo({ ...userInfo, username: e })}
                        />
                    </Item>
                    <Item floatingLabel style={S.inputCover} >
                        <Icon type="FontAwesome" name="envelope-o" style={S.inputIcon} />
                        <Label style={S.label}>EMAIL</Label>
                        <Input
                            style={[S.CLW, S.FW400, S.FRoboto]}
                            autoCapitalize={'none'}
                            keyboardType='email-address'
                            value={userInfo.email}
                            onChangeText={(e) => setUserInfo({ ...userInfo, email: e })}
                        />
                    </Item>
                    <Item floatingLabel style={S.inputCover}>
                        <Icon type="MaterialCommunityIcons" name="lock" style={S.inputIcon} />
                        <Label style={S.label}>PASSWORD</Label>
                        <Input
                            style={[S.CLW, S.FW400, S.FRoboto]}
                            secureTextEntry={true}
                            autoCapitalize={'none'}
                            value={userInfo.password}
                            onChangeText={(e) => setUserInfo({ ...userInfo, password: e })}
                        />
                    </Item>
                    <Item floatingLabel style={S.inputCover}>
                        <Icon type="MaterialCommunityIcons" name="lock" style={S.inputIcon} />
                        <Label style={S.label}>CONFIRM PASSWORD</Label>
                        <Input
                            style={[S.CLW, S.FW400, S.FRoboto]}
                            secureTextEntry={true}
                            autoCapitalize={'none'}
                            value={userInfo.cpassword}
                            onChangeText={(e) => setUserInfo({ ...userInfo, cpassword: e })}
                        />
                    </Item>
                    <View style={[S.Aend, S.MT10]}>
                        <TouchableOpacity onPress={handleRegister}>
                            <LinearGradient
                                start={[1, 0]}
                                end={[0, 1]}
                                colors={COLOR.buttonGColor}
                                style={S.authButton}>
                                <Text style={[S.authButtonText, S.FRoboto]}>SIGN UP</Text>
                                <Icon type="AntDesign" name="arrowright" style={S.rightIcon} />
                            </LinearGradient>
                        </TouchableOpacity>
                    </View>
                    <View style={S.MT20}>
                        <Text style={[S.orText, S.FRoboto]}>Or Sign up with</Text>
                    </View>
                    <View style={[S.MT15, S.ROW, S.Jcenter]}>
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
                    <View style={[S.MT15, S.ROW, S.Jcenter]}>
                        <Text style={[S.orText, S.FRoboto]}>Already have an account?   </Text>
                        <TouchableOpacity onPress={() => navigation.push('LoginScreen')}>
                            <Text style={[S.orText, S.FRoboto, S.FW700, S.CText7]}>Sign in</Text>
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