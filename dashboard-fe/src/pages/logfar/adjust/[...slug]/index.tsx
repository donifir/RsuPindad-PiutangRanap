import axios from 'axios'
import Link from 'next/link';
import React, { FC, useEffect, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
// import DatePicker, { CalendarContainer } from 'react-datepicker';
import DatePicker from "react-datepicker";
import dynamic from 'next/dynamic';
import TableComponent from '../component/TableComponent';
import ComponentButtonLink from '@/components/ComponentButtonLink';
import { BsBackspaceFill } from 'react-icons/bs';
import DeleteDataSatuBulan from '../component/DeleteDataSatuBulan';
import { IoCreateOutline } from 'react-icons/io5';
import { useRouter } from 'next/router';


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
          <div className='flex flex-row gap-3'>
            <ComponentButtonLink label="Back" link="/logfar/adjust" icon={<BsBackspaceFill />} bg="bg-red-800" styleText="text-slate-100" />
            <ComponentButtonLink label="Create" link={`/logfar/adjust/create/${id}`} icon={<IoCreateOutline />} bg="bg-green-800" styleText="text-slate-100" />
          </div>
        </div>
      </div>
      <div className='bg-white bg-opacity-70  mt-4 rounded-md shadow-xl py-2'>
        <div className="overflow-x-auto">
          <TableComponent/>
        </div>
      </div>
    </div>
  )
}

export default index