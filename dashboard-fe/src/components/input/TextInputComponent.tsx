import React, { FC } from "react";

type Props = {
	label: string;
	value: any;
	onChange: any;
	error: any;
	disabled: any;
};
const TextInputComponent: FC<Props> = (props) => {
	return (
		<div className="mt-4">
			<div className="flex flex-row justify-between">
				<label className="text-slate-700">
					{props.label}
				</label>
				<span className="text-red-500">{props.error ? props.error : ''}</span>
			</div>
			{props.disabled ?
				(
					<input
						disabled
						type="text"
						placeholder="Type here"
						className="input input-bordered w-full mt-2 border-slate-400"
						value={props.value}
						onChange={props.onChange}
					/>
				) :
				(
					<input
						type="text"
						placeholder="Type here"
						className="input input-bordered w-full mt-2 border-slate-400"
						value={props.value}
						onChange={props.onChange}
					/>
				)}

		</div>
	)
};

export default TextInputComponent;