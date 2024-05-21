
import axios from 'axios'
import Link from 'next/link';
import React, { FC, useEffect, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
import DatePicker from "react-datepicker";



function index() {
  const [data, setdatas] = useState<any>([]);
  const [tanggalBerita, setTanggalBerita] = useState<any>('');

  async function getDataTotal() {
    try {
      const response = await axios.get(`/taks-id-all/${tanggalBerita}`);
      setdatas(response.data);
      console.log(response.data);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    if (tanggalBerita) {
      getDataTotal()
    }
  }, [String(tanggalBerita)])

  const [selectedDate, setSelectedDate] = useState<any>(null);

  const handleDateChange = (date: Date | null) => {
    setSelectedDate(date);
    if (date) {
      const formattedDate = format(date, 'yyyy-MM-dd'); // Format the date
      setTanggalBerita(formattedDate)
      console.log(tanggalBerita); // Output the formatted date
    }
  };


  return (
    <div>
      <div className='flex flex-row gap-3  pt-4 ml-[20px] '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            <p className='text-2xl'>Taks-id /taks-id-all/{tanggalBerita}</p>
            <p className='text-[12px] text-[#8E9BAE]'>Based on yoru preferences</p>
          </div>
          <div>
            <form action="">

              <div className="flex flex-row mr-10">
                <div className="customDatePickerWidth">
                  <DatePicker
                    selected={selectedDate}
                    onChange={handleDateChange}
                    dateFormat="yyyy-MM-dd"
                    placeholderText="Masukan Tanggal"
                    className="input input-bordered w-[100%] min-w-max"
                  />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div className='bg-white bg-opacity-70  mt-5 m-3 rounded-md shadow-xl py-2 '>
        <div className="verflow-x-auto">
          <table className="table table-xs table-zebra table-auto">
            {/* head */}
            <thead>
              <tr>
                <th ></th>
                <th >Tanggal</th>
                <th >Jumlah Data</th>
                <th >Jumlah Data SP</th>
                <th >Taskid-1</th>
                <th >Taskid-2</th>
                <th >Taskid-3</th>
                <th >Taskid-4</th>
                <th >Taskid-5</th>
                <th >Taskid-6</th>
                <th >Taskid-7</th>
              </tr>
            </thead>
            <tbody>
              {/* row 1 */}
              <tr >
                <td></td>
                <td>{data.tanggal}</td>
                <td>{data.total_regis}</td>
                <td>{data.total_regis_sp}</td>
                <td>{data.taks1}</td>
                <td>{data.taks2}</td>
                <td>{data.taks3}</td>
                <td>{data.taks4}</td>
                <td>{data.taks5}</td>
                <td>{data.taks6}</td>
                <td>{data.taks7}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  )
}

export default index