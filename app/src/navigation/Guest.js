import React from 'react'
import { NavigationContainer } from "@react-navigation/native"
import { createStackNavigator } from '@react-navigation/stack'
import Login from '../screens/Guest/Login'
import CreateAccount from '../screens/Guest/CreateAccount'
import { LAYOUT } from '../constants'

const Stack = createStackNavigator()

const Guest = () => {
	return (
		<NavigationContainer>
			<Stack.Navigator initialRouteName='LoginScreen'>
				<Stack.Screen name="LoginScreen" component={Login} options={LAYOUT.headerOption} />
				<Stack.Screen name="CreateAccountScreen" component={CreateAccount} options={LAYOUT.headerOption} />
			</Stack.Navigator>
		</NavigationContainer>
	)
}


export default Guest