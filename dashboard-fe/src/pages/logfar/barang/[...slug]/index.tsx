
import React, { FC, useEffect, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import DetailBarangComponent from '../component/DetailBarangComponent';
import { useRouter } from 'next/router';
import ComponentButtonLink from '@/components/ComponentButtonLink';
import { BsBackspaceFill } from 'react-icons/bs';



const index = () => {

  const router = useRouter();
  const id = router.query.slug

  return (
    <div>
      <div className='flex flex-row gap-3  pt-4 '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            <p className='text-2xl'>Your Personal Learning</p>
            <p className='text-[12px] text-[#8E9BAE]'>Based on yoru preferences</p>
          </div>
          <div>
            <ComponentButtonLink label="Backs" link="/logfar/adjust" icon={<BsBackspaceFill />} bg="bg-red-800" styleText="text-slate-100" />
          </div>
        </div>
      </div>
      <div className='bg-white bg-opacity-70  mt-4 rounded-md shadow-xl py-2'>
        <div className="overflow-x-auto">
          {/* <TableComponent/> */}
          <DetailBarangComponent id={id} />
        </div>
      </div>
    </div>
  )
}

export default index