import { createAppContainer } from "react-navigation"
import { createStackNavigator } from 'react-navigation-stack'
import LoginScreen from '../screens/Guest/LoginScreen'
import CreateAccountScreen from '../screens/Guest/CreateAccountScreen'

const HomeNavigator = createStackNavigator(
	{
		LoginScreen: {
			screen: LoginScreen,
			navigationOptions: { header: null },
		},
		CreateAccountScreen: {
			screen: CreateAccountScreen,
			navigationOptions: { header: null },
		}
	},
	{
		initialRouteName: 'LoginScreen',
	}
)

export default createAppContainer(HomeNavigator)