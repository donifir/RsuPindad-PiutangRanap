import Image from 'next/image'
import Link from 'next/link'
import React from 'react'
import { BiSolidDashboard } from 'react-icons/bi'
import { GiWolfHowl } from 'react-icons/gi'
import { IoMdCompass } from 'react-icons/io'
import { MdOutlineMedicalServices } from "react-icons/md";
import { HiMiniAdjustmentsHorizontal } from "react-icons/hi2";


function SideBarComponent() {
  return (
    <div className='fixed'>
      <div className='flex flex-row gap-3'>
        <div className='bg-slate-100  rounded-full  w-16 h-16 flex justify-center items-center'>
          <GiWolfHowl size={45} />
        </div>
        <div className='flex justify-center items-center '>
          <p className=' text-2xl'>Dashboard</p>
        </div>
      </div>

      {/* content sidebar */}
      {/* <div className='bg-white  bg-opacity-70 mt-5 m-3 rounded-md shadow-xl py-2 w-[200px] text-sm'>
        <div className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={20} /></div>
          <div className='my-auto'>Dashboard</div>
        </div>
        <div className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={20} /></div>
          <div className='my-auto'>Explore</div>
        </div>
        <div className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={20} /></div>
          <div className='my-auto'>My Setting</div>
        </div>
        <div className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={20} /></div>
          <div className='my-auto'>Calendar</div>
        </div>
      </div> */}

      {/* content sidebar 2*/}
      <div className='bg-white bg-opacity-70 mt-5 m-3 rounded-md shadow-xl py-2 text-sm w-full '>
        <Link href="/logfar/adjust">
          <div className='flex flex-row gap-3 py-1 my-1 px-2'>
            <div className='my-auto w-7'><HiMiniAdjustmentsHorizontal size={20} /></div>
            <div className='my-auto'>Saldo Awal</div>
          </div>
        </Link>

        <Link href="/logfar">
          <div className='flex flex-row gap-3 py-1 my-1 px-2'>
            <div className='my-auto w-7'><MdOutlineMedicalServices size={20} /></div>
            <div className='my-auto'>Logfar Data</div>
          </div>
        </Link>
        
        {/* <div className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={20} /></div>
          <div className='my-auto'>My Setting</div>
        </div>
        <div className='flex flex-row gap-3 py-1 my-1 px-2'>
          <div className='my-auto w-7'><BiSolidDashboard size={20} /></div>
          <div className='my-auto'>Calendar</div>
        </div> */}
      </div>
    </div>
  )
}

export default SideBarComponent