import React from "react";
import ASSAPMo2 from "./ASSAP-MO-2.png";

export const MainContentSection = (): JSX.Element => {
  return (
    <section className="absolute top-16 left-0 w-[1282px] h-[595px]">
      <button
        className="all-[unset] box-border gap-2 px-8 py-6 absolute top-[431px] left-[416px] bg-secondary rounded-[99px] shadow-[2px_4px_4px_#00000040] inline-flex items-center justify-center overflow-hidden"
        type="button"
        aria-label="Registrarse como cliente"
      >
        <span className="mt-[-1.00px] font-link-normal font-[number:var(--link-normal-font-weight)] text-white text-[length:var(--link-normal-font-size)] tracking-[var(--link-normal-letter-spacing)] leading-[var(--link-normal-line-height)] relative w-fit whitespace-nowrap [font-style:var(--link-normal-font-style)]">
          CLIENTE
        </span>
      </button>

      <img
        className="absolute top-[527px] left-[1220px] w-14 h-14 aspect-[1] object-cover"
        alt="Assap MO"
        src={ASSAPMo2}
      />

      <header className="absolute top-0 left-0 w-[1280px] h-[595px] flex gap-[146px] bg-transparent shadow-[0px_10px_10px_#00000080] bg-[url(/banner.png)] bg-[100%_100%]">
        <button
          className="mt-[445px] w-[133px] h-[61.23px] relative ml-[437px] gap-2 px-8 py-6 bg-secondary rounded-[99px] shadow-[2px_4px_4px_#00000040] inline-flex items-center justify-center overflow-hidden"
          type="button"
          aria-label="Registrarse como cliente"
        >
          <span className="mt-[-0.38px] font-link-normal font-[number:var(--link-normal-font-weight)] text-white text-[length:var(--link-normal-font-size)] tracking-[var(--link-normal-letter-spacing)] leading-[var(--link-normal-line-height)] relative w-fit whitespace-nowrap [font-style:var(--link-normal-font-style)]">
            CLIENTE
          </span>
        </button>

        <button
          className="mt-[439.9px] w-[119px] h-[61.23px] relative gap-2 px-8 py-6 bg-secondary rounded-[99px] shadow-[2px_4px_4px_#00000040] inline-flex items-center justify-center overflow-hidden"
          type="button"
          aria-label="Registrarse como local"
        >
          <span className="mt-[-0.38px] font-link-normal font-[number:var(--link-normal-font-weight)] text-white text-[length:var(--link-normal-font-size)] tracking-[var(--link-normal-letter-spacing)] leading-[var(--link-normal-line-height)] relative w-fit whitespace-nowrap [font-style:var(--link-normal-font-style)]">
            LOCAL
          </span>
        </button>
      </header>

      <h1 className="absolute top-3.5 left-[131px] w-[991px] h-[252px] flex items-center justify-center [text-shadow:0px_10px_10px_#00000040] [-webkit-text-stroke:1px_#000000] font-title-hero font-[number:var(--title-hero-font-weight)] text-[#ffffff] text-[length:var(--title-hero-font-size)] text-center tracking-[var(--title-hero-letter-spacing)] leading-[var(--title-hero-line-height)] [font-style:var(--title-hero-font-style)]">
        Menos enredos, más momentos juntos
      </h1>
    </section>
  );
};
