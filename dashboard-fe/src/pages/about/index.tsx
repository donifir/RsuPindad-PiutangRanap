import ContentHome from '@/components/ContentHome'
import HeaderContentHome from '@/components/HeaderContentHome'
import NavbarComponent from '@/components/NavbarComponent'
import SideBarComponent from '@/components/SideBarComponent'
import Image from 'next/image'
import React from 'react'
import { AiOutlineUser } from 'react-icons/ai'
import { BiSolidDashboard } from 'react-icons/bi'
import { GiWolfHowl } from 'react-icons/gi'
import { IoMdNotificationsOutline } from 'react-icons/io'

function index() {
  return (
    <div>
      <ContentHome />
    </div>
  )
}

export default index