/**
 * Column layout icons.
 */

const iconHeader = {
	viewBox: '0 0 60 30',
	height: '26',
	xmlns: 'http://www.w3.org/2000/svg',
	fillRule: 'evenodd',
	clipRule: 'evenodd',
	strokeLinejoin: 'round',
	strokeMiterlimit: '1.414',
};

const icons = {

	/* Two columns - 50/50. */
	twoEqual: (
		<svg
			{...iconHeader}
		>
			<rect x="32" y="0" width="28" height="30" fill="#6d6a6f" />
			<rect x="0" y="0" width="28" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Two columns - 75/25. */
	twoLeftWide: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="42" height="30" fill="#6d6a6f" />
			<rect x="46" y="0" width="14" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Two columns - 25/75. */
	twoRightWide: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="14" height="30" fill="#6d6a6f" />
			<rect x="18" y="0" width="42" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Two columns - 75/25. */
	twoLeftWideThird: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="37" height="30" fill="#6d6a6f" />
			<rect x="41" y="0" width="18" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Two columns - 25/75. */
	twoRightWideThird: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="18" height="30" fill="#6d6a6f" />
			<rect x="22" y="0" width="37" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Three columns - 33/33/33. */
	threeEqual: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="17.500" height="30" fill="#6d6a6f" />
			<rect x="21.500" y="0" width="17.500" height="30" fill="#6d6a6f" />
			<rect x="43" y="0" width="17.500" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Three column - 25/50/25. */
	threeWideCenter: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="11" height="30" fill="#6d6a6f" />
			<rect x="15" y="0" width="31" height="30" fill="#6d6a6f" />
			<rect x="50" y="0" width="11" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Three column - 25/50/25. */
	threeWideCenterSmallLeft: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="8" height="30" fill="#6d6a6f" />
			<rect x="12" y="0" width="25" height="30" fill="#6d6a6f" />
			<rect x="41" y="0" width="17" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Three column - 25/50/25. */
	threeWideCenterSmallCenter: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="25" height="30" fill="#6d6a6f" />
			<rect x="29" y="0" width="8" height="30" fill="#6d6a6f" />
			<rect x="41" y="0" width="17" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Three column - 50/25/25. */
	threeWideLeft: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="30" height="30" fill="#6d6a6f" />
			<rect x="34" y="0" width="11" height="30" fill="#6d6a6f" />
			<rect x="49" y="0" width="11" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Three column - 25/25/50. */
	threeWideRight: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="11" height="30" fill="#6d6a6f" />
			<rect x="15" y="0" width="11" height="30" fill="#6d6a6f" />
			<rect x="30" y="0" width="30" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Four column - 25/25/25/25. */
	fourEqual: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="12" height="30" fill="#6d6a6f" />
			<rect x="16" y="0" width="12" height="30" fill="#6d6a6f" />
			<rect x="32" y="0" width="12" height="30" fill="#6d6a6f" />
			<rect x="48" y="0" width="12" height="30" fill="#6d6a6f" />
		</svg>
	),


	/* Four column - 50/16/16/16. */
	fourLeft: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="24" height="30" fill="#6d6a6f" />
			<rect x="28" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="39" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="50" y="0" width="7" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Four column - 20/20/20/40. */
	fourRight: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="11" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="22" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="33" y="0" width="24" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Four column - 16/33/33/16. */
	fourCenter: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="11" y="0" width="15" height="30" fill="#6d6a6f" />
			<rect x="30" y="0" width="15" height="30" fill="#6d6a6f" />
			<rect x="49" y="0" width="7" height="30" fill="#6d6a6f" />
		</svg>
	),

	/* Four column - 33/16/16/33. */
	fourOutside: (
		<svg
			{...iconHeader}
		>
			<rect x="0" y="0" width="15" height="30" fill="#6d6a6f" />
			<rect x="19" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="30" y="0" width="7" height="30" fill="#6d6a6f" />
			<rect x="41" y="0" width="15" height="30" fill="#6d6a6f" />
		</svg>
	),


	/* Block icon. */
	blockIcon: (
		<svg
			viewBox="0 0 60 34"
			height="34"
			xmlns="http://www.w3.org/2000/svg"
			fillRule="evenodd"
			clipRule="evenodd"
			strokeLinejoin="round"
			strokeMiterlimit="1.414"
		>
			<rect x="38" y="0" width="12" height="34" fill="#6d6a6f" />
			<rect x="22" y="0" width="12" height="34" fill="#6d6a6f" />
			<rect x="6" y="0" width="12" height="34" fill="#6d6a6f" />
		</svg>
	),

};

