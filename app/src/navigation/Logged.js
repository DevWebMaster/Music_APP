import * as React from "react"
import normalize from "react-native-normalize"
import { View, Image, TouchableOpacity } from "react-native"
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs'
import { NavigationContainer } from "@react-navigation/native"
import { createStackNavigator } from "@react-navigation/stack"
import Media1 from '../screens/Logged/Media1'
import Media2 from '../screens/Logged/Media2'
import Media3 from '../screens/Logged/Media3'
import Player from '../screens/Logged/Player'
import Profile from '../screens/Logged/Profile'
import Unwiind from '../screens/Logged/Unwiind'
import Favorites from '../screens/Logged/Favorites'
import Recent from '../screens/Logged/Recent'
import Forum from '../screens/Logged/Forum'
import ChatThread from '../screens/Logged/ChatThread'
import ChatPrivate from '../screens/Logged/ChatPrivate'
import Content from '../screens/Logged/Content'
import { COLOR, Images, LAYOUT, Styles } from "../constants"
import { navigate, setNavigator } from "../redux/services/navigator"

const BottomTab = createBottomTabNavigator()
const Stack = createStackNavigator()

const BottomTabNavigator = () => {
	return (
		<BottomTab.Navigator
			tabBarOptions={{
				style: { height: normalize(60), borderTopWidth: 0 },
				tabStyle: { height: normalize(60), backgroundColor: COLOR.Footer, borderTopWidth: 0 }
			}}
			initialRouteName='UnwiindScreen'
			keyboardHidesTabBar={true}
		>
			<BottomTab.Screen
				name="UnwiindScreen"
				component={Unwiind}
				options={{
					title: () => null,
					tabBarIcon: () => <Image source={Images.Home} style={Styles.FooterIcon} />
				}}
			/>
			<BottomTab.Screen
				name="Media2Screen"
				component={Media2}
				options={{
					title: () => null,
					tabBarIcon: () => <Image source={Images.L1} style={Styles.FooterIcon} />
				}}
			/>
			<BottomTab.Screen
				name="Media1Screen"
				component={Media1}
				options={{
					title: () => null,
					tabBarIcon: () => (
						<View style={Styles.FooterLogo}>
							<TouchableOpacity onPress={() => navigate('Media1Screen')}>
								<Image source={Images.LogoGif} style={Styles.Logo} />
							</TouchableOpacity>
						</View>
					)
				}}
			/>
			<BottomTab.Screen
				name="ForumScreen"
				component={Forum}
				options={{
					title: () => null,
					tabBarIcon: () => <Image source={Images.Chat} style={Styles.FooterIcon} />
				}}
			/>
			<BottomTab.Screen
				name="ProfileScreen"
				component={Profile}
				options={{
					title: () => null,
					tabBarIcon: () => <Image source={Images.User} style={Styles.FooterIcon} />
				}}
			/>
			<BottomTab.Screen name="ContentScreen" component={Content} options={LAYOUT.bottomOption} />
			<BottomTab.Screen name="Media3Screen" component={Media3} options={LAYOUT.bottomOption} />
			<BottomTab.Screen name="PlayerScreen" component={Player} options={LAYOUT.bottomOption} />
			<BottomTab.Screen name="FavoritesScreen" component={Favorites} options={LAYOUT.bottomOption} />
			<BottomTab.Screen name="RecentScreen" component={Recent} options={LAYOUT.bottomOption} />
		</BottomTab.Navigator>
	)
}

const Navigation = () => {
	return (
		<NavigationContainer ref={setNavigator}>
			<Stack.Navigator initialRouteName='MainScreen'>
				<Stack.Screen name="MainScreen" component={BottomTabNavigator} options={LAYOUT.headerOption} />
				<Stack.Screen name="ChatThreadScreen" component={ChatThread} options={LAYOUT.headerOption} />
				<Stack.Screen name="ChatPrivateScreen" component={ChatPrivate} options={LAYOUT.headerOption} />
			</Stack.Navigator>
		</NavigationContainer>
	)
}

export default Navigation
