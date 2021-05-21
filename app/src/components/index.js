import React from "react"
import { ActivityIndicator, StyleSheet, View, Image } from 'react-native'
import { Button, Footer, FooterTab } from "native-base"
import { COLOR, Images, Styles } from "../constants"
import normalize from "react-native-normalize"
import { navigate } from "../redux/services/navigator"

export const Loading = () => {
  return (
    <View style={styles.container}>
      <ActivityIndicator animating={true} size="large" color={COLOR.greenColor} />
    </View>
  )
}

export const Footers = () => {
  const onNavigate = (e) => {
    navigate(e)
  }
  return(
    <Footer style={{height:normalize(60), borderTopWidth:0}}>
      <FooterTab style={[Styles.BKFooter, {borderTopWidth:0}]}>
        <Button vertical onPress={() => onNavigate('UnwiindScreen')}>
          <Image source={Images.Home} style={Styles.FooterIcon}/>
        </Button>
        <Button vertical onPress={() => onNavigate('Media1Screen')}>
          <Image source={Images.L1} style={Styles.FooterIcon}/>
        </Button>
        <View style={Styles.FooterLogo}>
          <Image source={Images.Logo} style={Styles.Logo}/>
        </View>
        <Button vertical onPress={() => onNavigate('LiveStreamScreen')}>
          <Image source={Images.Chat} style={Styles.FooterIcon}/>
        </Button>
        <Button vertical onPress={() => onNavigate('ProfileScreen')}>
          <Image source={Images.User} style={Styles.FooterIcon}/>
        </Button>
      </FooterTab>
    </Footer>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
})


