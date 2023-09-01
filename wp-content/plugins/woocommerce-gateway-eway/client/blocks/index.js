/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerPaymentMethod } from '@woocommerce/blocks-registry';

/**
 * Internal dependencies
 */
import ComponentCreditCard from './component-credit-card';
import ComponentSavedToken from './component-saved-token';
import { PAYMENT_METHOD_NAME } from './constants';
import { getEWAYServerData } from './eway-utils';

const Label = ( props ) => {
	const { PaymentMethodLabel } = props.components;

	const labelText = getEWAYServerData().title
		? getEWAYServerData().title
		: __( 'Credit Card', 'wc-eway' );

	return <PaymentMethodLabel text={ labelText } />;
};

const EWAYComponent = ( { RenderedComponent, ...props } ) => {
	return <RenderedComponent { ...props } />;
};

registerPaymentMethod( {
	name: PAYMENT_METHOD_NAME,
	label: <Label />,
	ariaLabel: __( 'Eway payment method', 'wc-eway' ),
	canMakePayment: () => true,
	content: <EWAYComponent RenderedComponent={ ComponentCreditCard } />,
	edit: <EWAYComponent RenderedComponent={ ComponentCreditCard } />,
	savedTokenComponent: (
		<EWAYComponent RenderedComponent={ ComponentSavedToken } />
	),
	supports: {
		features: getEWAYServerData()?.supports ?? [],
		showSavedCards: getEWAYServerData().showSavedCards ?? false,
	},
} );
