import React from 'react'
import { StatusBar } from 'react-native'
import { Provider } from 'react-redux'
import {PersistGate} from 'redux-persist/integration/react'
import Router from './src/Router'
import { COLOR } from './src/constants'
import getTheme from "./src/theme/components"
import variables from "./src/theme/variables/commonColor"
import {store, persistor} from './src/redux/Store'
import { StyleProvider, Root } from "native-base"
import { YellowBox } from 'react-native'

YellowBox.ignoreWarnings(['VirtualizedLists should never be nested'])
const App = () => {
  return (
    <StyleProvider style={getTheme(variables)}>
      <Provider store={store}>
        <PersistGate persistor={persistor} loading={null}>
          <Root>
            <StatusBar
              barStyle="light-content"
              backgroundColor={COLOR.blueColor7}
            />
            <Router />
          </Root>
        </PersistGate>
      </Provider>
    </StyleProvider>
  )
}

export default App
