import { createAppContainer } from "react-navigation"
import { createStackNavigator } from 'react-navigation-stack'
import Media1Screen from '../screens/Logged/Media1Screen'
import Media2Screen from '../screens/Logged/Media2Screen'
import Media3Screen from '../screens/Logged/Media3Screen'
import PlayerScreen from '../screens/Logged/PlayerScreen'
import ProfileScreen from '../screens/Logged/ProfileScreen'
import UnwiindScreen from '../screens/Logged/UnwiindScreen'
import LiveStreamScreen from '../screens/Logged/LiveStreamScreen'

const HomeNavigator = createStackNavigator(
	{
		Media1Screen: {
			screen: Media1Screen,
			navigationOptions: { header: null },
		},
		Media2Screen: {
			screen: Media2Screen,
			navigationOptions: { header: null },
		},
		Media3Screen: {
			screen: Media3Screen,
			navigationOptions: { header: null },
		},
		PlayerScreen: {
			screen: PlayerScreen,
			navigationOptions: { header: null },
		},
		ProfileScreen: {
			screen: ProfileScreen,
			navigationOptions: { header: null },
		},
		UnwiindScreen: {
			screen: UnwiindScreen,
			navigationOptions: { header: null },
		},
		LiveStreamScreen: {
			screen: LiveStreamScreen,
			navigationOptions: { header: null },
		},
	},
	{
		initialRouteName: 'UnwiindScreen',
	}
)

export default createAppContainer(HomeNavigator)