import React, { useEffect, useState } from "react"
import { LogBox, StatusBar } from 'react-native'
import { Provider } from 'react-redux'
import { Root } from "native-base"
import * as Font from "expo-font"
import AppLoading from "expo-app-loading"
import { PersistGate } from 'redux-persist/integration/react'
import { COLOR, LAYOUT } from './src/constants'
import Navigation from './src/navigation'
import { store, persistor } from './src/redux/Store'

LogBox.ignoreLogs(LAYOUT.warnings)

const App = () => {
  const [isLoading, setIsLoading] = useState(true)
  const _loadResourcesAsync = async () => {
    return await Promise.all([
      Font.loadAsync({
        Roboto: require("native-base/Fonts/Roboto.ttf"),
        Roboto_medium: require("native-base/Fonts/Roboto_medium.ttf"),
        Merienda: require("./src/assets/Merienda-Regular.ttf"),
      }),
    ])
  }
  const _handleLoadingError = (error) => {
    console.warn(error)
  }

  const _handleFinishLoading = () => {
    setIsLoading(false)
  }

  if (isLoading) {
    return (
      <AppLoading
        startAsync={_loadResourcesAsync}
        onError={_handleLoadingError}
        onFinish={_handleFinishLoading}
      />
    )
  } else {
    return (
      <Provider store={store}>
        <PersistGate persistor={persistor} loading={null}>
          <Root>
            <StatusBar
              barStyle="light-content"
              backgroundColor={COLOR.blueColor7}
            />
            <Navigation />
          </Root>
        </PersistGate>
      </Provider>
    )
  }
}

export default App