/**
 * External dependencies
 */
import { getSetting } from '@woocommerce/settings';

/**
 * Eway data comes form the server passed on a global object.
 */
export const getEWAYServerData = () => {
	const ewayServerData = getSetting( 'eway_data', null );
	if ( ! ewayServerData || typeof ewayServerData !== 'object' ) {
		throw new Error( 'Eway initialization data is not available' );
	}
	return ewayServerData;
};
