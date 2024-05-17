import Image from 'next/image'
import React from 'react'
import {AiOutlineUser} from 'react-icons/ai';
import {IoMdNotificationsOutline} from 'react-icons/io'
function NavbarComponent() {
  return (
    <div className="flex flex-row justify-between gap-4  ">
      <div className=''> 
        <p className='text-[20px] font-extrabold'>Learn.io</p>
        <p className='text-[#8E9BAE] text-[12px]'>Learn.io</p>
      </div>
      <div className=' '>
        <div className='flex-row flex gap-5'>
          <Image
            src="/assets/images/Group40104.png"
            width={50}
            height={50}
            alt="Picture of the author"
          />
          <Image
            src="/assets/images/Group40104.png"
            width={50}
            height={50}
            alt="Picture of the author"
          />
          <Image
            src="/assets/images/Group40104.png"
            width={50}
            height={50}
            alt="Picture of the author"
          />
          <Image
            src="/assets/images/Group40104.png"
            width={50}
            height={50}
            alt="Picture of the author"
          />
          <Image
            src="/assets/images/Group40104.png"
            width={50}
            height={50}
            alt="Picture of the author"
          />
          <Image
            src="/assets/images/Group40104.png"
            width={50}
            height={50}
            alt="Picture of the author"
          />
        </div>
      </div>
      <div className='flex flex-row justify-end items-center	gap-5'>
        <div>
          <AiOutlineUser size="25"/>
        </div>
        <div>
          <IoMdNotificationsOutline size="25"/>
        </div>
      </div>
      
    </div>
  )
}

export default NavbarComponent