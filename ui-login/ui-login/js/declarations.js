
      const { bnToBn, u8aToHex } =  polkadotUtil;
      const { sha256AsU8a, blake2AsHex, randomAsHex, selectableNetworks } = polkadotUtilCrypto;
      const { Keyring } = polkadotKeyring;
      const { cryptoWaitReady } = polkadotUtilCrypto;
      const { ApiPromise, WsProvider } = polkadotApi; //require('@polkadot/api');
      //const { Keyring } = require('@polkadot/keyring');
      const { randomAsU8a, randomAsNumber, signatureVerify } = polkadotUtilCrypto; // require( '@polkadot/util-crypto');
      const { stringToU8a, stringToHex, hexToString } = polkadotUtil1;
      const { web3Accounts, web3Enable, web3FromAddress,
        web3ListRpcProviders,
              web3FromSource,
        web3UseRpcProvider
       } = polkadotExtensionDapp ;

