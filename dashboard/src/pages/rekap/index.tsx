import axios from 'axios'
import React, { FC, useEffect, useRef, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
// import DatePicker, { CalendarContainer } from 'react-datepicker';
import DatePicker from "react-datepicker";
import TableHiddenComponent from '@/components/TableHiddenComponent';
import Link from 'next/link';
import Head from 'next/head';



function index() {
  const [loading, setLoading] = useState<boolean>(true);
  const [tanggalBerita, setTanggalBerita] = useState<any>(new Date().toISOString().split('T')[0]);
  const [totals, setTotals] = useState<any>([]);
  const [filter, setFilter] = useState<any>('all')

  async function getDataTotal() {
    try {
      const response = await axios.get(`/total/${filter}/${tanggalBerita}`);
      setTotals(response.data);
      console.log(response.data.data);
      setLoading(false)
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getDataTotal()
  }, [String(tanggalBerita), String(filter)])

  const [selectedDate, setSelectedDate] = useState<any>(null);

  const handleDateChange = (date: Date | null) => {
    setLoading(true)
    setSelectedDate(date);
    if (date) {
      const formattedDate = format(date, 'yyyy-MM-dd'); // Format the date
      setTanggalBerita(formattedDate)
      console.log(tanggalBerita); // Output the formatted date
    }
  };

  return (
    <div>
      <Head>
        <title>Rekap Piurang Ranap</title>
      </Head>
      <div className='flex flex-row gap-3  pt-4 ml-[20px] '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            <p className='text-2xl'>Data Piutang Ranap</p>
            <div className='flex flex-row gap-4'>
              {/* link */}
              <Link href="/data" className="btn btn-outline btn-success btn-sm capitalize">Data</Link>
              <Link href="/rekap" className="btn btn-outline btn-success btn-sm capitalize">Rekap</Link>
            </div>
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
      <div className='bg-white bg-opacity-70 dark:bg-slate-600/90 mt-5 m-3 rounded-md shadow-xl py-2 '>
        <div className="verflow-x-auto">
          {loading ? (
            <div className='flex justify-center items-center h-14'>
              loading
            </div>) : (<>
              <TableHiddenComponent tanggal={tanggalBerita} />
            </>)}
        </div>

      </div>
    </div>
  )
}

export default index