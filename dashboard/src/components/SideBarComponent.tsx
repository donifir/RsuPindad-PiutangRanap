import Image from 'next/image'
import Link from 'next/link'
import React from 'react'
import { BiSolidDashboard } from 'react-icons/bi'
import { GiWolfHowl } from 'react-icons/gi'


function SideBarComponent() {
  return (
    <div className='min-h-[500px]'>
      <div className='flex flex-row gap-3'>
        <div className='bg-slate-100  rounded-full  w-16 h-16 flex justify-center items-center'>
          <GiWolfHowl size={45} />
        </div>
        <div className='flex justify-center items-center '>
          <p className=' text-2xl'>NAO Tech</p>
        </div>
      </div>

      {/* content sidebar */}
      <div className='bg-white  bg-opacity-70 mt-5 m-3 rounded-md shadow-xl py-2 w-[200px]'>
        <Link href="/" className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={23} /></div>
          <div className='my-auto'>Grafik Piutang</div>
        </Link>
        <Link href="/data" className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={23} /></div>
          <div className='my-auto'>Data Tabel Pitang</div>
        </Link>
      </div>
    </div>
  )
}

export default SideBarComponent