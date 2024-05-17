import Link from 'next/link'
import React, { FC } from 'react'
import { BsBackspaceFill } from 'react-icons/bs'

type Props ={
  label:string,
  link?:string,
  icon:any;
  bg:string
  styleText:string
}

const ComponentButtonLink:FC<Props> = (props) => {
  return (
    <div>
      <Link href={{ pathname:props.link }} className={` cursor-pointer p-2 rounded-md  text-center px-2 flex flex-row justify-center items-center gap-2 ${props.bg} ${props.styleText}` }>
        {props.icon} {props.label}
      </Link>
    </div>
  )
}

export default ComponentButtonLink