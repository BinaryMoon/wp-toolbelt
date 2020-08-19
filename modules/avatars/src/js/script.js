; (
	() => {

		/**
		 * The number of 'pixels' wide the avatar is.
		 *
		 * @type {int}
		 */
		const width = 11;

		/**
		 * The number of 'pixels' high the avatar is.
		 *
		 * @type {int}
		 */
		const height = 11;

		/**
		 * The width of the avatar canvas.
		 * For best results this needs to divide evenly by the width value.
		 *
		 * @type {int}
		 */
		const canvasWidth = 506;

		/**
		 * The height of the avatar canvas.
		 * For best results this needs to divide evenly by the height value.
		 *
		 * @type {int}
		 */
		const canvasHeight = 506;

		/**
		 * Store the current index we are reading from the hash.
		 *
		 * @type {int}
		 */
		let hashIndex = 0;


		/**
		 * Get the value of the next character in the hash.
		 * Uses `hashIndex` to track which value we are reading.
		 * `hashIndex` should be reset each time we create a new avatar.
		 *
		 * @param {string} id The avatar id hash.
		 * @return {int}
		 */
		const stringVal = ( id ) => {

			hashIndex++;

			return id[ hashIndex ].charCodeAt( 0 );

		};


		/**
		 * Pick the key of the shape to use for the specified part.
		 *
		 * @param {string} id The avatar id hash.
		 * @param {string} name The name of the part to pick a shape from.
		 * @return {array} The data for the selected shape.
		 */
		const getParts = ( id, name ) => {

			const index = stringVal( id ) % pixelParts[ name ].length;
			return pixelParts[ name ][ index ];

		};


		/**
		 * Generate a color.
		 *
		 * You can experiment with colours...
		 * @see https://www.w3schools.com/colors/colors_hsl.asp
		 *
		 * @param {string} id The avatar id hash.
		 * @param {int} sat The saturation value.
		 * @param {int} light The lightness value.
		 * @param {int} range The size of the hue range to use.
		 * @param {int} rangeOffset The amount to offset the start of the hue range.
		 * @return {array}
		 */
		const getColor = ( id, sat, light, paletteId = 'all' ) => {

			const palette = pixelParts.palette[ paletteId ];
			const index = stringVal( id ) % palette.length;
			const hue = palette[ index ];

			return [
				`hsl(${hue}, ${sat}%, ${light}%)`,
				`hsl(${hue}, ${sat + 10}%, ${light - 20}%)`
			];

		};


		/**
		 * Decide what colour to use based on the value of shape, and the
		 * palette being used.
		 *
		 * @param {int} pixel The index for the pixel in the shape.
		 * @param {string} current The current colour in use for the pixel.
		 * @param {array} palette The colours to pick from.
		 * @return {string} The colour selected for the pixel.
		 */
		const setPixelColour = ( pixel, current, palette ) => {

			let colour = current;

			switch ( pixel ) {
				case 1:
					colour = palette[ 0 ];
					break;
				case 2:
					colour = palette[ 1 ];
					break;
				case 8:
					colour = 'white';
					break;
				case 9:
					colour = 'black';
					break;
			}

			return colour;

		};


		/**
		 * Create an empty drawing array.
		 *
		 * @return {array}
		 */
		const newArray = () => {

			let data = [];

			for ( let y = 0; y < height; y++ ) {
				data[ y ] = [];
				for ( let x = 0; x < width; x++ ) {
					data[ y ][ x ] = null;
				}
			}

			return data;

		};


		/**
		 * Add a background colour to the avatar.
		 *
		 * @param {string} id The avatar id hash.
		 * @param {array} data The avatar pixel array.
		 * @return {array}
		 */
		const addBackground = ( id, data ) => {

			const colour = getColor( id, 80, 87 );

			for ( let y = 0; y < height; y++ ) {
				for ( let x = 0; x < width; x++ ) {
					data[ x ][ y ] = colour[ 0 ];
				}
			}

			return data;

		};


		/**
		 * Add a face.
		 *
		 * @param {string} id The avatar id hash.
		 * @param {array} data The avatar pixel array.
		 * @return {array}
		 */
		const addFace = ( id, data ) => {

			/**
			 * White skin colours are in the hue range from 0 to 60 and 350 to
			 * 360. So, we will ignore these colours.
			 *
			 * To do this I will set the range from 0 - 290, and the rangeOffset
			 * to 60.
			 * This will push the colour range to the middle of the hue spectrum.
			 */
			const colour = getColor( id, 40, 65, 'skin' );

			const face = getParts( id, 'face' );

			const yOffset = 3;

			for ( let y = 0; y < face.length; y++ ) {
				for ( let x = 0; x < width; x++ ) {
					data[ y + yOffset ][ x ] = setPixelColour( face[ y ][ x ], data[ y + yOffset ][ x ], colour );
				}
			}

			return data;

		};


		/**
		 * Add a mouth.
		 *
		 * @param {string} id The avatar id hash.
		 * @param {array} data The avatar pixel array.
		 * @return {array}
		 */
		const addMouth = ( id, data ) => {

			const mouth = getParts( id, 'mouth' );
			const colour = getColor( id, 60, 30 );

			data[ 6 ][ 4 ] = 1 === mouth[ 0 ] ? colour[ 0 ] : data[ 6 ][ 4 ];
			data[ 6 ][ 5 ] = 1 === mouth[ 1 ] ? colour[ 0 ] : data[ 6 ][ 5 ];
			data[ 6 ][ 6 ] = 1 === mouth[ 2 ] ? colour[ 0 ] : data[ 6 ][ 6 ];

			return data;

		};


		/**
		 * Add a body.
		 *
		 * @param {string} id The avatar id hash.
		 * @param {array} data The avatar pixel array.
		 * @return {array}
		 */
		const addBody = ( id, data ) => {

			const colour = getColor( id, 50, 45 );
			const body = getParts( id, 'body' );

			const yOffset = 8;

			for ( let y = 0; y < height - yOffset; y++ ) {
				for ( let x = 0; x < width; x++ ) {
					data[ y + yOffset ][ x ] = setPixelColour( body[ y ][ x ], data[ y + yOffset ][ x ], colour );
				}
			}

			return data;

		};


		/**
		 * Add hair to the avatar.
		 *
		 * @param {string} id The avatar id hash.
		 * @param {array} data The avatar pixel array.
		 * @return {array}
		 */
		const addHair = ( id, data ) => {

			const colour = getColor( id, 70, 45 );
			const hair = getParts( id, 'hair' );

			for ( let y = 0; y < hair.length; y++ ) {
				for ( let x = 0; x < width; x++ ) {
					data[ y ][ x ] = setPixelColour( hair[ y ][ x ], data[ y ][ x ], colour );
				}
			}

			return data;

		};


		/**
		 * Draw the avatar.
		 *
		 * @param {object} canvas The canvas object for the current avatar.
		 * @param {array} data The avatar pixel array.
		 * @return {void}
		 */
		const draw = ( canvas, data ) => {

			canvas.width = canvasWidth;
			canvas.height = canvasHeight;

			const tileWidth = canvasWidth / width;
			const tileHeight = canvasHeight / height;

			const context = canvas.getContext( '2d' );

			for ( let y = 0; y < height; y++ ) {
				for ( let x = 0; x < width; x++ ) {
					context.fillStyle = data[ y ][ x ];
					context.fillRect( x * tileWidth, y * tileHeight, tileWidth, tileHeight );
				}
			}

		};


		window.pixelGen = window.pixelGen || {};

		/**
		 * Generate the avatar.
		 *
		 * @param {object} canvas The canvas to draw the avatar on.
		 * @param {string} id The hash to generate the avatar from.
		 * @return {void}
		 */
		window.pixelGen.generate = ( canvas, id = null ) => {

			if ( !id ) {
				return;
			}

			let data = newArray();

			// Reset the hash.
			hashIndex = 0;

			data = addBackground( id, data );
			data = addBody( id, data );
			data = addFace( id, data );
			data = addMouth( id, data );
			data = addHair( id, data );

			draw( canvas, data );

		};


		/**
		 * Generate all avatars for canvases with the specified class.
		 *
		 * @param {string} selector The class name for the canvas selector.
		 * @return {void}
		 */
		window.pixelGen.generateAllAvatars = ( selector = '.pixelAvatar' ) => {

			const canvases = document.querySelectorAll( `canvas${selector}` );

			canvases.forEach(
				( item ) => {
					pixelGen.generate( item, item.getAttribute( 'data-hash' ) );
				}
			);

		};

	}

)();
