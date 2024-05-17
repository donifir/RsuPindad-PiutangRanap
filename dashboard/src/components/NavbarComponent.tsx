import Image from 'next/image'
import React from 'react'
import { AiOutlineUser } from 'react-icons/ai';
import { IoMdNotificationsOutline } from 'react-icons/io'
function NavbarComponent() {
  return (
    <div className='flex flex-row justify-between'>
      <div>
        <p className='text-[20px] font-bold'>Learn.io</p>
        <p className='text-[#8E9BAE] text-[12px]'>Learn.io</p>
      </div>
     
      <div className='flex flex-row justify-end '>
        <div>
          <AiOutlineUser size="25" />
        </div>
        <div>
          <IoMdNotificationsOutline size="25" />
        </div>
      </div>
    </div>
  )
}

export default NavbarComponent