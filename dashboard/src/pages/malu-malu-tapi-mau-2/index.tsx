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
  const [loading, setLoading] = useState<boolean>(false);
  const [tanggalBerita, setTanggalBerita] = useState<any>('');
  const [filter, setFilter] = useState<any>('all')


  async function getDataTotal() {
    setLoading(true)
    try {
      const response = await axios.get(`/get-sep-2/${tanggalBerita}`);
      setdatas(response.data.data);
      console.log(response.data.data);
      setLoading(false)
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

  const filteredData = datas.filter((data: any) => data.no_sep.includes(filter));
  const totalDataFiltered = filteredData.length;
  const totalData = datas.length;


  return (
    <div>
      <div className='flex flex-row gap-3  pt-4 ml-[20px] '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            <p className='text-2xl'>Data Sep</p>
            <p className='text-[12px] text-[#8E9BAE]'>Bang koi Kcepian Tanpa Dierinya (bang koi Ci hua Hua)</p>
            <p className='text-xl'>Total Data {filter=='all'?totalData:totalDataFiltered}</p>

          </div>
          <div>
            <form action="" className='flex flex-row mr-3'>

              <div className="flex flex-row mr-3">
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

              <select
                className="select select-bordered w-full font-medium"
                // defaultValue={status}
                value={filter}
                onChange={(e) => setFilter(e.target.value)}
              >
                <option value={'all'}>Semua</option>
                <option value={'018'}>SEP Sudah Tercetak</option>
                <option value={'-'}>SEP Belum Tercetak</option>
              </select>
            </form>
          </div>
        </div>
      </div>
      <div className='bg-white bg-opacity-70  mt-5 m-3 rounded-md shadow-xl py-2 '>
        <div className="verflow-x-auto">
          {loading == true ? 'Loading' :
            <table className="table table-xs table-zebra table-auto">
              {/* head */}
              <thead>
                <tr>
                  <th ></th>
                  <th >No Rawat</th>
                  <th >No Rm</th>
                  <th >Nama Pasien</th>
                  <th >Poliklinik</th>
                  <th >Penanggungjawab</th>
                  <th >Tanggal Registrasi</th>
                  <th >Nomer SEP</th>
                  {/* <th>Kamar</th> */}
                </tr>
              </thead>
              <tbody>
                {/* row 1 */}
                {/* {datas
                  // .filter((data: any) => data.tgl_masuk <= tanggalBerita)
                  .map((data: any, index: any) => (
                    <tr key={index}>
                      <td>{index + 1}</td>
                      <td>{data.no_rawat}</td>
                      <td>{data.norm}</td>
                      <td>{data.pasien}</td>
                      <td>{data.penanggungjawab}</td>
                      <td >{data.tgl_registrasi}</td>
                      <td >{data.no_sep}</td>
                    </tr>
                  ))} */}

                {filter == 'all' ? (
                  datas
                    .map((data: any, index: any) => (
                      <tr key={index}>
                        <td>{index + 1}</td>
                        <td>{data.no_rawat}</td>
                        <td>{data.norm}</td>
                        <td>{data.pasien}</td>
                        <td>{data.poli}</td>
                        <td>{data.penanggungjawab}</td>
                        <td >{data.tgl_registrasi}</td>
                        <td >{data.no_sep}</td>
                      </tr>
                    ))
                ) : (
                  filteredData
                    // .filter((data: any) => data.no_sep.includes(filter))
                    .map((data: any, index: any) => (
                      <tr key={index}>
                        <td>{index + 1}</td>
                        <td>{data.no_rawat}</td>
                        <td>{data.norm}</td>
                        <td>{data.pasien}</td>
                        <td>{data.poli}</td>
                        <td>{data.penanggungjawab}</td>
                        <td >{data.tgl_registrasi}</td>
                        <td >{data.no_sep}</td>
                      </tr>
                    ))
                )}
              </tbody>
            </table>}
        </div>
      </div>
    </div>
  )
}

export default index