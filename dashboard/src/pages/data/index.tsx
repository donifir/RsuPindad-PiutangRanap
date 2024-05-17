import FindKamarComponent from '@/components/ext/FindKamarComponent';
import FindLaboratComponent from '@/components/ext/FindLaboratComponent';
import FindObatComponent from '@/components/ext/FindObatComponent';
import FindOperasiComponent from '@/components/ext/FindOperasiComponent';
import FindRadiologiComponent from '@/components/ext/FindRadiologiComponent';
import FindTindakanComponent from '@/components/ext/FindTindakanComponent';
import axios from 'axios'
import React, { FC, useEffect, useRef, useState } from 'react'
import 'react-datepicker/dist/react-datepicker.css';
import { format } from 'date-fns';
import DatePicker from "react-datepicker";
import { useDownloadExcel } from 'react-export-table-to-excel';
import Link from 'next/link';
import Head from 'next/head';
import FindRegistrasiComponent from '@/components/ext/FindRegistrasiComponent';

function index() {
  const [datas, setdatas] = useState<any>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [tanggalBerita, setTanggalBerita] = useState<any>(new Date().toISOString().split('T')[0]);
  const [registrasis, setDataRegistrasis] = useState<any>([]);

  const [tindakanLayanandr, setTindakanLayanandr] = useState<any>([])
  const [tindakanLayananpr, setDataTindakanLayananpr] = useState<any>([]);
  const [tindakanLayanandrpr, setDataTindakanLayanandrpr] = useState<any>([]);
  const [tindakanUmum, setDataTindakanUmum] = useState<any>([]);
  const [tindakanInapDr, setDataTindakanInapDr] = useState<any>([]);
  const [tindakanInapDrPr, setDataTindakanInapDrPr] = useState<any>([]);

  const [obats, setObats] = useState<any>([]);
  const [radiologis, setRadiologis] = useState<any>([]);
  const [Loborats1, setLaborats1] = useState<any>([]);
  const [Loborats2, setLaborats2] = useState<any>([]);
  const [kamars, setKamars] = useState<any>([]);
  const [operasis, setOperasis] = useState<any>([]);
  const [totals, setTotals] = useState<any>([]);
  const [filter, setFilter] = useState<any>('all')


  async function getDataPiutang() {
    try {
      const response = await axios.get(`/get-data-ranap/${filter}/${tanggalBerita}`);
      setdatas(response.data.data);
    } catch (error) {
      console.error(error);
    }
  }


  async function getDataAllTindakan() {
    try {
      const response = await axios.get(`/all-tindakan/${filter}/${tanggalBerita}`);
      setDataRegistrasis(response.data.registrasi);
      // tindakan
      setDataTindakanLayanandrpr(response.data.layanandrpr);
      setTindakanLayanandr(response.data.layanandr);
      setDataTindakanLayananpr(response.data.layananpr);
      setDataTindakanUmum(response.data.umum);
      setDataTindakanInapDr(response.data.rawatInapDr);
      setDataTindakanInapDrPr(response.data.rawatInapDrPr);
      //obat
      setObats(response.data.obat);
      //radiologi
      setRadiologis(response.data.radiologi);
      //laborat
      setLaborats1(response.data.laborat1);
      setLaborats2(response.data.laborat2);
      //kamar
      setKamars(response.data.biaya);
      setLoading(false)
      //operasi
      setOperasis(response.data.operasi);

    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getDataPiutang()
    getDataAllTindakan()
  }, [String(tanggalBerita), String(filter)])

  // const time = now.toLocaleTimeString();

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

  const tableRef = useRef(null);

  const { onDownload } = useDownloadExcel({
    currentTableRef: tableRef.current,
    filename: 'Users table',
    sheet: 'Users'
  })

  return (
    <div>
      <Head>
        <title>Rekap Piurang Ranap {filter}</title>
      </Head>
      <div className='flex flex-row gap-3  pt-4 ml-[20px] '>
        <div className='flex flex-row justify-between items-center w-full'>
          <div>
            <p className='text-2xl'>Data Piutang Ranap</p>
            <div className='flex flex-row gap-3'>
              {/* link */}
              <Link href="/data" className="btn btn-outline btn-success btn-sm capitalize">Data</Link>
              <Link href="/rekap" className="btn btn-outline btn-success btn-sm capitalize">Rekap</Link>
            </div>
          </div>
          <div>
            <form action="">
              <div className="flex flex-row mr-10">
                <select
                  className="select select-bordered w-full font-medium"
                  // defaultValue={status}
                  value={filter}
                  onChange={(e) => setFilter(e.target.value)}
                >
                  <option value={'show'}>Semua</option>
                  <option value={'bpjs'}>BPJS Kesehatan</option>
                  <option value={'ketenagakerjaan'}>BPJS Ketenaga Kerjaan</option>
                  <option value={'cob'}>COB</option>
                  <option value={'kon'}>Kontraktor</option>
                  <option value={'umum'}>Umum</option>
                </select>
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
              <button onClick={onDownload} className='btn btn-outline btn-warning btn-sm lowercase mx-4'> Export to excel </button>
              <table className="table table-xs table-zebra table-auto" ref={tableRef}>
                {/* head */}
                <thead>
                  <tr>
                    <th ></th>
                    <th >No Rawat</th>
                    <th >No Rm</th>
                    <th >Nama Pasien</th>
                    <th >Penjamin</th>
                    <th >Registrasi</th>
                    <th >Tindakan</th>
                    <th >Obat</th>
                    <th >Laborat</th>
                    <th >Radiologi</th>
                    <th >Kamar</th>
                    <th >Operasi</th>
                    <th >Total</th>
                    {/* <th>Kamar</th> */}
                  </tr>
                </thead>

                <tbody>
                  {/* row 1 */}
                  {datas
                    .filter((data: any) => data.tgl_masuk <= tanggalBerita)
                    // .filter((data: any) => new Date(data.tgl_masuk).getMonth() ==new Date(tanggalBerita).getMonth() )
                    .map((data: any, index: any) => (
                      <tr key={index}>
                        <td>{index + 1}</td>
                        <td>{data.tgl_masuk}</td>
                        <td>{data.norm}</td>
                        <td>{data.pasien}</td>
                        <td>{data.penanggungjawab}</td>
                        {/* registrasi */}

                        <td>
                          {FindRegistrasiComponent({ data: registrasis, norawat: data.no_rawat })}
                        </td>
                        <td>
                          {FindTindakanComponent({
                            norawat: data.no_rawat,
                            layananDrPr: tindakanLayanandrpr,
                            layananDr: tindakanLayanandr,
                            layananPr: tindakanLayananpr,
                            umum: tindakanUmum,
                            inapDr: tindakanInapDr,
                            inapDrPr: tindakanInapDrPr,

                          })}
                        </td>
                        <td>
                          {FindObatComponent({ data: obats, norawat: data.no_rawat })}
                        </td>
                        <td>
                          {FindLaboratComponent({ laborat1: Loborats1, laborat2: Loborats2, norawat: data.no_rawat })}
                        </td>
                        <td>
                          {FindRadiologiComponent({ data: radiologis, norawat: data.no_rawat })}
                        </td>
                        <td>
                          {FindKamarComponent({ data: kamars, norawat: data.no_rawat })}
                        </td>
                        <td>
                          {FindOperasiComponent({ data: operasis, norawat: data.no_rawat })}
                        </td>
                        {/* total */}
                        <td>

                          {
                            //  @ts-ignore
                            FindTindakanComponent({
                              norawat: data.no_rawat,
                              layananDrPr: tindakanLayanandrpr,
                              layananDr: tindakanLayanandr,
                              layananPr: tindakanLayananpr,
                              umum: tindakanUmum,
                              inapDr: tindakanInapDr,
                              inapDrPr: tindakanInapDrPr,

                            }) +
                            // @ts-ignore
                            FindRegistrasiComponent({ data: registrasis, norawat: data.no_rawat }) +
                            FindObatComponent({ data: obats, norawat: data.no_rawat }) +
                            FindLaboratComponent({ laborat1: Loborats1, laborat2: Loborats2, norawat: data.no_rawat }) +
                            FindRadiologiComponent({ data: radiologis, norawat: data.no_rawat }) +
                            FindKamarComponent({ data: kamars, norawat: data.no_rawat }) +
                            FindOperasiComponent({ data: operasis, norawat: data.no_rawat })
                          }
                        </td>
                      </tr>
                    ))}
                </tbody>
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th>
                      {registrasis.reduce((total: any, item: any) => total + item.biaya_reg, 0)}
                    </th>
                    <th>

                      {
                        tindakanLayanandr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                        tindakanLayananpr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                        tindakanLayanandrpr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                        tindakanUmum.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                        tindakanInapDr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                        tindakanInapDrPr.reduce((total: any, item: any) => total + item.biaya_rawat, 0)
                      }
                    </th>
                    <th>

                      {obats.reduce((total: any, item: any) => total + item.total, 0)}
                    </th>
                    <th>

                      {
                        Loborats1.reduce((total: any, item: any) => total + item.biaya, 0) +
                        Loborats2.reduce((total: any, item: any) => total + item.biaya_item, 0)
                      }
                    </th>
                    <th>

                      {radiologis.reduce((total: any, item: any) => total + item.biaya, 0)}
                    </th>
                    <th>

                      {kamars.reduce((total: any, item: any) => total + item.biaya, 0)}
                    </th>
                    <th>

                      {operasis.reduce((total: any, item: any) => total + item.total_operasi, 0)}
                    </th>
                    <th>
                      {
                        (registrasis.reduce((total: any, item: any) => total + item.biaya_reg, 0)
                        ) + (
                          tindakanLayanandr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                          tindakanLayananpr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                          tindakanLayanandrpr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                          tindakanUmum.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                          tindakanInapDr.reduce((total: any, item: any) => total + item.biaya_rawat, 0) +
                          tindakanInapDrPr.reduce((total: any, item: any) => total + item.biaya_rawat, 0)
                        ) + (
                          obats.reduce((total: any, item: any) => total + item.total, 0)
                        ) + (
                          Loborats1.reduce((total: any, item: any) => total + item.biaya, 0) +
                          Loborats2.reduce((total: any, item: any) => total + item.biaya_item, 0)
                        ) + (
                          radiologis.reduce((total: any, item: any) => total + item.biaya, 0)
                        ) + (
                          kamars.reduce((total: any, item: any) => total + item.biaya, 0)
                        ) + (
                          operasis.reduce((total: any, item: any) => total + item.total_operasi, 0)
                        )
                      }
                    </th>
                  </tr>
                </thead>
              </table>
            </>)}
        </div>

      </div>
    </div>
  )
}

export default index