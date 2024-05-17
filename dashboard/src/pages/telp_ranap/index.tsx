import { formatRupiah } from '@/components/FormatRupiah';
import HeaderContentHome from '@/components/HeaderContentHome'
import FindKamarComponent from '@/components/ext/FindKamarComponent';
import FindLaboratComponent from '@/components/ext/FindLaboratComponent';
import FindObatComponent from '@/components/ext/FindObatComponent';
import FindOperasiComponent from '@/components/ext/FindOperasiComponent';
import FindRadiologiComponent from '@/components/ext/FindRadiologiComponent';
import FindTextComponent from '@/components/ext/FindTextComponent';
import FindTindakanComponent from '@/components/ext/FindTindakanComponent';
import axios from 'axios'
import Link from 'next/link';
import React, { FC, useEffect, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
// import DatePicker, { CalendarContainer } from 'react-datepicker';
import DatePicker from "react-datepicker";



function index() {
  const [datas, setdatas] = useState<any>([]);
  const [tanggalBerita, setTanggalBerita] = useState<any>('');

  async function getDataTotal() {
    try {
      const response = await axios.get(`/telp/${tanggalBerita}`);
      setdatas(response.data.data);
      console.log(response.data.data);
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
            <p className='text-2xl'>Data Piutang Ranap</p>
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
                <th >No KTP</th>
                <th >No Rm</th>
                <th >Nama Pasien</th>
                <th >Penanggungjawab</th>
                <th >telp</th>
          
                {/* <th>Kamar</th> */}
              </tr>
            </thead>
            <tbody>
              {/* row 1 */}
              {datas
                .map((data: any, index: any) => (
                  <tr key={index}>
                    <td>{index + 1}</td>
                    <td>{data.no_ktp}</td>
                    <td>{data.no_rkm_medis}</td>
                    <td>{data.nm_pasien}</td>
                    <td>{data.penanggungjawab}</td>
                    <th >{data.no_tlp}</th>
                 

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