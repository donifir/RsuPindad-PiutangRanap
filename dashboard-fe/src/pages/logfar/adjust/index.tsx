import axios from 'axios'
import Link from 'next/link';
import React, { FC, useEffect, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
// import DatePicker, { CalendarContainer } from 'react-datepicker';
import DatePicker from "react-datepicker";
// import FormAdjust from '../component/FormAdjust';
import dynamic from 'next/dynamic';
import FormAdjust from './component/FormAdjust';
import ComponentButtonLink from '@/components/ComponentButtonLink';
import { BsBackspaceFill } from 'react-icons/bs';
import { BiEdit } from 'react-icons/bi';
import DeleteDataSatuBulan from './component/DeleteDataSatuBulan';



const index = () => {
  const [datas, setdatas] = useState<any>([]);
  const [count, setCount] = useState(0);

  async function getDataAdjust() {
    try {
      const response = await axios.get('/data-adjust');
      setdatas(response.data.data)
      console.log(response);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getDataAdjust()
  }, [String(count)])

  return (
    <div>
      <div className='flex flex-row gap-3  pt-4 '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            <p className='text-2xl'>Your Personal Learning</p>
            <p className='text-[12px] text-[#8E9BAE]'>Based on yoru preferences</p>
          </div>
          <div>
            <FormAdjust count={count} setCount={setCount} />
          </div>
        </div>
      </div>
      <div className='bg-white bg-opacity-70  mt-4 rounded-md shadow-xl py-2'>
        <div className="overflow-x-auto">
          <table className="w-full flex-wrap table justify-between">
            <thead>
              <tr>
                <th ></th>
                <th >Nama Bulan</th>
                <th >Total Data</th>

                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              {/* row 1 */}
              {datas
                .map((data: any, index: any) => (
                  <tr key={index}>
                    <td>{index + 1}</td>
                    <td>{data.nama_bulan}</td>
                    <td>{data.total_data}</td>
                    <td>
                      {/* <Link href={`/logfar/adjust/${data.nama_bulan}`}>
                        <button className="btn btn-sm btn-success lowercase">detail</button>
                      </Link> */}
                      <div className='flex flex-row gap-2'>
                        <ComponentButtonLink label="Detail" link={`/logfar/adjust/${data.nama_bulan}`} icon={<BiEdit />} bg="bg-slate-800" styleText="text-slate-100" />
                        <DeleteDataSatuBulan count={count} setCount={setCount} id={data?.nama_bulan} label={data?.nama_bulan} />
                      </div>
                    </td>
                  </tr>
                ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  )
}

export default index