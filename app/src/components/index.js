import React, { Fragment, useEffect } from "react"
import { ActivityIndicator, StyleSheet, View, Image, TouchableOpacity, Text, ImageBackground, TextInput } from 'react-native'
import { Button, Footer, FooterTab, Icon } from "native-base"
import { COLOR, DEV, Images, LAYOUT, Styles } from "../constants"
import normalize from "react-native-normalize"
import UserAvatar from 'react-native-user-avatar'
import { navigate } from "../redux/services/navigator"
import { LinearGradient } from 'expo-linear-gradient'
import { useDispatch, useSelector } from "react-redux"
import { setIsClose, setIsPlay } from "../redux/actions/musicActions"

export const UserAvatars = ({ style = {}, user = null, size = 35 }) => {
  if (user && user.avatar) {
    return (
      <View style={[style, S.Ascenter]}>
        <UserAvatar
          size={normalize(size)}
          src={`${DEV.IMAGE_URL}${user.avatar}`}
          bgColors={COLOR.chatColor}
        />
      </View>
    )
  } else if (user && user.email) {
    return (
      <View style={[style, S.Ascenter]}>
        <UserAvatar
          size={normalize(size)}
          name={user.email.slice(0, 2).toUpperCase()}
          bgColors={COLOR.chatColor}
        />
      </View>
    )
  } else {
    return <View />
  }
}

export const Loading = () => {
  return (
    <View style={S.container}>
      <ActivityIndicator animating={true} size="large" color={COLOR.greenColor} />
    </View>
  )
}

export const Footers = () => {
  const onNavigate = (e) => {
    navigate(e)
  }
  return (
    <Footer style={{ height: normalize(60), borderTopWidth: 0 }}>
      <FooterTab style={[S.BKFooter, { borderTopWidth: 0 }]}>
        <Button vertical onPress={() => onNavigate('UnwiindScreen')}>
          <Image source={Images.Home} style={S.FooterIcon} />
        </Button>
        <Button vertical onPress={() => onNavigate('Media2Screen')}>
          <Image source={Images.L1} style={S.FooterIcon} />
        </Button>
        <View style={S.FooterLogo}>
          <TouchableOpacity onPress={() => onNavigate('Media1Screen')}>
            <Image source={Images.LogoGif} style={S.Logo} />
          </TouchableOpacity>
        </View>
        <Button vertical onPress={() => onNavigate('ForumScreen')}>
          <Image source={Images.Chat} style={S.FooterIcon} />
        </Button>
        <Button vertical onPress={() => onNavigate('ProfileScreen')}>
          <Image source={Images.User} style={S.FooterIcon} />
        </Button>
      </FooterTab>
    </Footer>
  )
}

export const PlayerPreview = () => {
  const dispatch = useDispatch()
  const { isPlay, isClose, activeMusic, sound, loading } = useSelector(state => state.music)
  return (
    activeMusic &&
    <TouchableOpacity onPress={() => navigate('PlayerScreen')} style={{ position: 'absolute', bottom: 0 }}>
      <LinearGradient colors={COLOR.FooterPlayerColor} style={[S.FooterPlayer]} start={[0, 0]} end={[1, 1]}>
        <View style={[S.ROW, S.Acenter]}>
          <Image source={{ uri: `${DEV.IMAGE_URL}${activeMusic.thumb}` }} style={S.PlayerItems} />
          <View style={S.PL10}>
            <Text numberOfLines={1} style={[S.F14, S.FW700, S.CLW, S.FRoboto, { width: LAYOUT.window.width * 0.5 }]}>{activeMusic?.name}</Text>
            <Text numberOfLines={1} style={[S.F12, S.FW400, S.CText4, S.FRoboto, { width: LAYOUT.window.width * 0.5 }]}>{activeMusic?.description}</Text>
          </View>
        </View>
        <View style={[S.ROW, S.Acenter]}>
          {
            sound && loading ?
              <TouchableOpacity onPress={() => dispatch(setIsPlay(!isPlay))}>
                {
                  isPlay ?
                    <Icon type="AntDesign" name='pause' style={[S.F30, S.MR10, S.CLGrey2]} /> :
                    <Icon type="MaterialCommunityIcons" name="play" style={[S.F30, S.MR10, S.CLGrey2]} />
                }
              </TouchableOpacity>
              :
              <TouchableOpacity>
                <ActivityIndicator animating={true} size="small" color={COLOR.greenColor} style={S.MR10} />
              </TouchableOpacity>
          }
          <TouchableOpacity onPress={() => dispatch(setIsClose(!isClose))}>
            <Icon type="MaterialIcons" name="close" style={[S.F30, S.CLW]} />
          </TouchableOpacity>
        </View>
      </LinearGradient>
    </TouchableOpacity>
  )
}

export const PlayerList = ({ play, item }) => {
  return (
    <View style={[S.ROW, S.Acenter, S.Jbetween, S.MT20, { width: LAYOUT.window.width - normalize(40) }]}>
      <View style={[S.ROW, S.Acenter]}>
        <Image source={{ uri: `${DEV.IMAGE_URL}${item.thumb}` }} style={S.PlayerItems} />
        <View style={[S.PL10, { width: LAYOUT.window.width - normalize(200) }]}>
          <Text style={[S.F15, S.CLW, S.FRoboto]} numberOfLines={1}>{item.name}</Text>
          <Text style={[S.F12, S.FW400, S.FRoboto, S.MT5, S.CText6]} numberOfLines={1}>{item.playCounts} Listens</Text>
        </View>
      </View>
      <View style={[S.ROW, S.Acenter]}>
        <Text style={[S.F14, S.FW700, S.CLW, S.MR20, S.CText5, S.FRoboto]}> {item.duration} </Text>
        <TouchableOpacity style={S.playButton} onPress={() => play(item)}>
          <Icon type="MaterialCommunityIcons" name="play" style={[S.F20, S.CLBule2]} />
        </TouchableOpacity>
      </View>
    </View>
  )
}

export const FirstPlayerList = ({ item }) => {
  return (
    <TouchableOpacity onPress={() => navigate('Media2Screen', item)}>
      <ImageBackground source={{ uri: `${DEV.IMAGE_URL}${item.thumb_img}` }} style={S.FirstItem}>
        <View style={S.Cover}>
          <Text style={[S.F21, S.FW400, S.CLW, S.Tcenter, S.PH20, S.FMerienda]}>{item.name}</Text>
          <View style={S.newBadge}>
            <Text style={[S.F12, S.FW400, S.CLW, S.FRoboto, { paddingVertical: normalize(4) }]}>NEW</Text>
          </View>
        </View>
      </ImageBackground>
    </TouchableOpacity>
  )
}

export const LagePlayerList = ({ item, play }) => {
  return (
    <ImageBackground source={{ uri: `${DEV.IMAGE_URL}${item.thumb}` }} style={S.LageItem}>
      <TouchableOpacity style={S.LagePlayButton} onPress={() => play(item)}>
        <Icon type="MaterialCommunityIcons" name="play" style={[S.F24, S.CLW]} />
      </TouchableOpacity>
      <View>
        <Text style={[S.F14, S.FW700, S.CLW, S.FRoboto]} numberOfLines={1}>{item.name}</Text>
        <Text style={[S.F12, S.FW400, S.FRoboto, { color: '#b7b7b7' }]} numberOfLines={1}>{item.description}</Text>
      </View>
    </ImageBackground>
  )
}

export const RecommendedList = ({ item, play }) => {
  return (
    <TouchableOpacity onPress={() => play(item)}>
      <ImageBackground source={{ uri: `${DEV.IMAGE_URL}${item.thumb}` }} style={S.RecommendedListItem} />
      <View style={[S.Acenter, { width: LAYOUT.window.width * 0.25 }]}>
        <Text style={[S.F14, S.FW700, S.FRoboto, S.W100P, S.Tcenter, S.CLW]} numberOfLines={1}>{item.name}</Text>
        <Text style={[S.F12, S.FW400, S.FRoboto, S.W100P, S.Tcenter, { color: '#08838e' }]} numberOfLines={1}>{item.description}</Text>
      </View>
    </TouchableOpacity>
  )
}


export const ContentItemList = ({ item, play }) => {
  return (
    <TouchableOpacity onPress={() => play(item)}>
      <ImageBackground source={{ uri: `${DEV.IMAGE_URL}${item.thumb}` }} style={[S.ContentItem, S.MB10, S.PH15]}>
        <Text style={[S.F18, S.FW700, S.FRoboto, S.Tcenter, S.CLW]} numberOfLines={1}>{item.name}</Text>
        <Text style={[S.F14, S.FW400, S.FRoboto, S.Tcenter, { color: '#b3bac0' }]} numberOfLines={1}>{item.description}</Text>
      </ImageBackground>
    </TouchableOpacity>
  )
}


export const CategoryItem = ({ item, index }) => {
  return (
    <TouchableOpacity onPress={() => navigate('ContentScreen', item)}>
      <LinearGradient
        start={[1, 0]} end={[0, 1]}
        style={S.categoryButton}
        colors={COLOR[`categoryGColor${index % 3 + 1}`]}
      >
        <Text style={[S.categoryButtonText, S.FRoboto]} numberOfLines={1}>{item.name}</Text>
      </LinearGradient>
    </TouchableOpacity>
  )
}

export const SecondCategoryItem = ({ item, active, setActive }) => {
  return (
    <TouchableOpacity onPress={() => setActive(item)}>
      {
        item.id == active?.id ?
          <Fragment>
            <Text style={[S.CLBule4, S.F16, S.FW400, S.MR20, S.FRoboto]}> {item.name} </Text>
            <Icon type="Entypo" name="dot-single" style={S.SecondPoint} />
          </Fragment> :
          <Text style={[S.F16, S.FW400, S.MR20, S.CText8, S.FRoboto]}> {item.name} </Text>
      }
    </TouchableOpacity>
  )
}

export const ForumCategoryItem = ({ item, active, setActive }) => {
  return (
    <TouchableOpacity style={[S.ForumItem, active == item.id && S.ForumActive]} onPress={() => setActive(item.id)}>
      <Text style={[S.F16, S.CLW, S.FW700, S.FRoboto]}>{item.name}</Text>
    </TouchableOpacity>
  )
}

export const ForumItem = ({ item, members, onLike }) => {
  const member = members && members[item.id] ? Object.values(members[item.id]) : []
  const user1 = member[0]
  const user2 = member[1]
  const user3 = member[2]
  return (
    <TouchableOpacity style={[S.ForumChartItem]} onPress={() => navigate('ChatThreadScreen', { user1, user2, user3, id: item.id, name: item.name })}>
      <View style={[S.ROW, S.Acenter]}>
        <View>
          <UserAvatars user={user1} />
          <UserAvatars user={user2} style={S.ForumCover} />
        </View>
        <View style={[S.ML20]}>
          <Text style={[S.CLW, S.F18, S.FW700, S.FRoboto, { width: LAYOUT.window.width * 0.55 }]} numberOfLines={1}>{item.name}</Text>
          <Text style={[{ color: '#bac1ca' }, S.F12, S.FW400, S.MT10, S.FRoboto, { width: LAYOUT.window.width * 0.55 }]} numberOfLines={1}>{member.length} Members</Text>
        </View>
      </View>
      <TouchableOpacity onPress={() => onLike(item)}>
        <Icon type='AntDesign' name={item.is_liked == '1' ? 'heart' : 'hearto'} style={S.ForumIsLike} />
      </TouchableOpacity>
    </TouchableOpacity>

  )
}

export const AlbumItem = ({ item }) => {
  return (
    <TouchableOpacity onPress={() => navigate('Media3Screen', item)}>
      <Image source={{ uri: `${DEV.IMAGE_URL}${item.avatar_url}` }} style={S.AlbumItem} />
      <View style={[S.ROW, S.Jcenter, S.MT10]}>
        <Text style={[S.F12, S.FW400, S.FRoboto, { color: '#babfc7' }]}>{item.name}</Text>
        <Text style={[S.F12, S.FW400, S.FRoboto, S.CLBule1, S.PH15]}>|</Text>
        <Text style={[S.F12, S.FW400, S.FRoboto, { color: '#babfc7' }]}>{item.email}</Text>
      </View>
    </TouchableOpacity>
  )
}

export const ThreadMessage = ({ item, user }) => {
  return (
    <View style={[S.MessageCover]}>
      <TouchableOpacity disabled={item.user == user.id} onPress={() => navigate('ChatPrivateScreen', item)}>
        <UserAvatars user={item} />
      </TouchableOpacity>
      <View style={S.TextCover}>
        <Text style={[S.F13, S.CLW, S.FRoboto]}> {item.message} </Text>
      </View>
    </View>
  )
}

export const PrivateMessage = ({ item, user, userData }) => {
  if ((item.sender == user.id && item.receiver == userData.user) || (item.sender == userData.user && item.receiver == user.id)) {
    if (item.sender == user.id) {
      return (
        <View style={[S.MessageCover, S.Astart, S.Jend]}>
          <View style={[S.TextCover, S.MR10]}>
            <Text style={[S.F13, S.CLW, S.FRoboto]}> {item.message} </Text>
          </View>
          <View>
            <UserAvatars user={item} />
          </View>
        </View>
      )
    } else {
      return (
        <View style={[S.MessageCover]}>
          <View>
            <UserAvatars user={item} />
          </View>
          <View style={S.TextCover}>
            <Text style={[S.F13, S.CLW, S.FRoboto]}> {item.message} </Text>
          </View>
        </View>
      )
    }
  } else {
    return <View />
  }
}

export const ChatInput = ({ value, onChangeText, sendMessage }) => {
  return (
    <View style={S.ChatInputCover}>
      <TextInput
        value={value}
        onChangeText={onChangeText}
        placeholder='Please enter your message.'
        placeholderTextColor={COLOR.whiteColor}
        keyboardType='default'
        style={[S.ChatInput, S.FRoboto]}
      />
      <TouchableOpacity style={[{ position: 'absolute', right: -normalize(10) }, S.Acenter, S.Jcenter]} onPress={sendMessage}>
        <Image source={Images.Button} style={{ height: normalize(45), width: normalize(80), resizeMode: 'contain' }} />
        <Icon type="MaterialIcons" name="send" style={[S.CLW, S.F22, { position: 'absolute', left: normalize(35) }]} />
      </TouchableOpacity>
    </View>
  )
}

const S = StyleSheet.create({
  ...Styles,
  ChatInputCover: {
    width: '100%',
    overflow: 'hidden',
    borderRadius: normalize(50),
    shadowOffset: { width: 3, height: 1.5 },
    shadowColor: '#000',
    shadowOpacity: 0.5,
    shadowRadius: 3,
    elevation: 3,
  },
  ChatInput: {
    height: normalize(45),
    borderRadius: normalize(50),
    paddingLeft: normalize(20),
    paddingRight: normalize(70),
    backgroundColor: `#4752a8`,
    fontSize: normalize(13),
    color: COLOR.whiteColor,
  },
  MessageCover: {
    marginTop: normalize(10),
    flexDirection: 'row',
    shadowOffset: { width: 0.5, height: 1 },
    shadowColor: '#000',
    shadowOpacity: 0.2,
    shadowRadius: 0.5,
    elevation: 1,
    alignItems: 'flex-start'
  },
  TextCover: {
    maxWidth: LAYOUT.window.width * 0.65,
    minHeight: normalize(35),
    marginLeft: normalize(10),
    paddingVertical: normalize(12),
    paddingHorizontal: normalize(20),
    borderRadius: normalize(20),
    justifyContent: 'center',
    backgroundColor: '#2c3a6e'
  },
  playButton: {
    backgroundColor: COLOR.blueColor3,
    height: normalize(26),
    width: normalize(26),
    borderRadius: normalize(13),
    justifyContent: 'center',
    alignItems: 'center',
  },
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  Cover: {
    width: '100%',
    height: '100%',
    backgroundColor: 'rgba(0,0,0,0.6)',
    paddingVertical: normalize(30),
    justifyContent: 'flex-end'
  },
  FirstItem: {
    overflow: 'hidden',
    borderRadius: normalize(20),
    width: LAYOUT.window.width * 0.5,
    height: LAYOUT.window.width * 0.6,
    alignItems: 'center',
    marginRight: normalize(15),
  },
  newBadge: {
    backgroundColor: COLOR.greenColor1,
    borderRadius: normalize(15),
    position: 'absolute',
    left: normalize(20),
    top: normalize(20),
    paddingHorizontal: normalize(10)
  },
  categoryButton: {
    marginRight: normalize(10),
    height: normalize(65),
    width: normalize(160),
    paddingHorizontal: normalize(20),
    borderRadius: normalize(10),
    alignItems: 'flex-start',
    justifyContent: 'center',
  },
  categoryButtonText: {
    color: COLOR.whiteColor,
    fontSize: normalize(16),
    textAlign: 'center',
  },
  LageItem: {
    overflow: 'hidden',
    borderRadius: normalize(15),
    width: LAYOUT.window.width * 0.38,
    height: LAYOUT.window.width * 0.38,
    paddingHorizontal: normalize(10),
    paddingVertical: normalize(10),
    resizeMode: 'contain',
    justifyContent: 'flex-end',
    marginRight: normalize(15),
  },
  LagePlayButton: {
    backgroundColor: 'rgba(0,0,0,0.7)',
    height: normalize(34),
    width: normalize(34),
    borderRadius: normalize(17),
    top: normalize(10),
    right: normalize(10),
    justifyContent: 'center',
    alignItems: 'center',
    position: 'absolute',
  },
  SecondPoint: {
    position: 'absolute',
    top: -normalize(10),
    right: normalize(2),
    color: COLOR.blueColor4
  },
  AlbumItem: {
    overflow: 'hidden',
    borderRadius: normalize(10),
    width: LAYOUT.window.width * 0.7,
    height: LAYOUT.window.width * 0.38,
    paddingHorizontal: normalize(10),
    paddingVertical: normalize(10),
    justifyContent: 'flex-end',
    marginRight: normalize(15),
  },
  ForumActive: {
    backgroundColor: COLOR.blueColor2
  },
  ForumItem: {
    paddingHorizontal: normalize(15),
    paddingVertical: normalize(7),
    borderRadius: normalize(20),
    marginRight: normalize(10),
    backgroundColor: COLOR.blueColor8,
  },
  ForumCover: {
    marginLeft: normalize(-10),
    marginTop: normalize(-25),
  },
  ForumChartItem: {
    marginTop: normalize(20),
    borderRadius: normalize(10),
    paddingVertical: normalize(10),
    paddingHorizontal: normalize(20),
    backgroundColor: "#203d61",
    justifyContent: 'space-between',
    flexDirection: 'row',
    alignItems: 'center',
  },
  ForumIsLike: {
    color: COLOR.redColor4,
    fontSize: normalize(24)
  },
  RecommendedListItem: {
    overflow: 'hidden',
    borderRadius: normalize(10),
    width: LAYOUT.window.width * 0.27,
    height: LAYOUT.window.width * 0.25,
    paddingHorizontal: normalize(10),
    paddingVertical: normalize(10),
    resizeMode: 'contain',
    justifyContent: 'flex-end',
    marginRight: normalize(15),
  },
  ContentItem: {
    overflow: 'hidden',
    borderRadius: normalize(15),
    width: (LAYOUT.window.width - normalize(60)) * 0.5,
    height: (LAYOUT.window.width - normalize(60)) * 0.5,
    paddingVertical: normalize(20),
    resizeMode: 'contain',
    alignItems: 'center',
    justifyContent: 'flex-end',
    marginRight: normalize(15),
  },
})