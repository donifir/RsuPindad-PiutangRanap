import React, { FC } from 'react'
import { BsFillEyeFill } from 'react-icons/bs';

type Props ={
  label:string,
  icon:any;
  bg:string
  styleText:string
}

const ComponentButtonOnly:FC<Props> = (props) => {
  return (
    <div>
      <div className={`cursor-pointer p-2 rounded-md  text-center px-2 flex flex-row justify-center items-center gap-2 ${props.bg} ${props.styleText}` }>
        {props.icon}{props.label}
      </div>
    </div>
  )
}

export default ComponentButtonOnly