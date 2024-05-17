import HeaderContentHome from '@/components/HeaderContentHome'
import axios from 'axios'
import React, { useEffect, useState } from 'react'
import {
  CChart,
  CChartBar,
  CChartLine,
  CChartDoughnut,
  CChartRadar,
  CChartPie,
  CChartPolarArea,
} from '@coreui/react-chartjs'

function index() {
  const [data, setdata] = useState<any>([]);
  const [tanggalBerita, setTanggalBerita] = useState<any>(new Date().toISOString().split('T')[0]);

  async function getDataTotal() {
    try {
      const response = await axios.get(`/total/all/${tanggalBerita}`);
      setdata(response.data);
      console.log(response.data);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    getDataTotal()
  }, [])


  return (
    <div>
      <HeaderContentHome label='Grafik Piutang Ranap' create='no' />
      <div className='bg-white bg-opacity-70  mt-5 m-3 rounded-md shadow-xl py-2'>
        <div className="overflow-x-auto">
          <div className='w-[70%] mx-auto'>
            <CChartBar
              // type='line'
              data={{
                labels: data.data_label,
                datasets: [
                  {
                    label: 'Data Piutang Ranap',
                    backgroundColor: 'rgba(179,181,198,0.2)',
                    borderColor: 'rgba(179,181,198,1)',
                    pointBackgroundColor: 'rgba(179,181,198,1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(179,181,198,1)',
                    // tooltipLabelColor: 'rgba(179,181,198,1)',
                    data: data.data_angka
                  },
                  // {
                  //   label: '2020',
                  //   backgroundColor: 'rgba(255,99,132,0.2)',
                  //   borderColor: 'rgba(255,99,132,1)',
                  //   pointBackgroundColor: 'rgba(255,99,132,1)',
                  //   pointBorderColor: '#fff',
                  //   pointHoverBackgroundColor: '#fff',
                  //   pointHoverBorderColor: 'rgba(255,99,132,1)',
                  //   // tooltipLabelColor: 'rgba(255,99,132,1)',
                  //   data: [28, 48, 40, 19, 96, 27, 100]
                  // }
                ],
              }}
              options={{
                aspectRatio: 1.5,
                // tooltips: {
                //   enabled: true
                // }
              }}
            />
          </div>
        </div>
      </div>
    </div>
  )
}

export default index