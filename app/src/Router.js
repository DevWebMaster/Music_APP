import React from 'react'
import { useSelector } from 'react-redux'
import GuestNavigation from './navigate/Guest'
import LoggedNavigation from './navigate/Logged'

const Router = () => {
  const { user } = useSelector((store) => store.auth)
  if (user) {
    return <LoggedNavigation />
  } else {
    return <GuestNavigation />
  }
}

export default Router
