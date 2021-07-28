import { Dimensions } from 'react-native'
const { width, height } = Dimensions.get('window')

export const LAYOUT = {
	window: { width, height },
	warnings: [`The method or property`, 'Setting a timer', `Cannot complete operation`, `VirtualizedLists should never be nested`, '`flexWrap: `wrap`', `Can't perform a React`],
	headerOption: {
		headerShown: false,
		animationEnabled: false
	},
	bottomOption: {
		title: () => null,
		tabBarButton: () => null
	},
}