import MasterDashboardComponent from "@/components/MasterDashboardComponent";
import "@/styles/globals.css";
import axios from "axios";
import type { AppProps } from "next/app";
import Head from "next/head";
import { ToastContainer } from "react-toastify";

export const header = {
  headers: {
    'Content-Type': 'multipart/form-data',
    Accept: 'application/json',
  },
};

axios.defaults.baseURL = 'http://192.168.2.9:8000/api';
// axios.defaults.baseURL = 'http://127.0.0.1:8000/api';


export default function App({ Component, pageProps }: AppProps) {
  return (
    <MasterDashboardComponent>
      <Head>
        <title>Logfar.!!</title>
      </Head>
      <ToastContainer />
      <Component {...pageProps} />
    </MasterDashboardComponent>
  )
}
